<?php

require("../conexao.php");

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../ex3/login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_amigo = $_GET['id'];

$conexao->beginTransaction();

try {

    $comando = "
        DELETE FROM pendentes
        WHERE id_usuario = :id_amigo
        AND id_amigo = :id_usuario
    ";

    $stm = $conexao->prepare($comando);

    $stm->execute([
        ':id_amigo' => $id_amigo,
        ':id_usuario' => $id_usuario
    ]);

    $comando = "
        INSERT INTO amigos
        (id_usuario, id_amigo)
        VALUES
        (:id_usuario, :id_amigo),
        (:id_amigo, :id_usuario)
    ";

    $stm = $conexao->prepare($comando);

    $stm->execute([
        ':id_usuario' => $id_usuario,
        ':id_amigo' => $id_amigo
    ]);

    $conexao->commit();

    echo "Amizade aprovada com sucesso.";

} catch (Exception $e) {

    $conexao->rollBack();

    echo "Erro ao aprovar amizade.";

}

?>