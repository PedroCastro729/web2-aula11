<?php

require("../conexao.php");

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../ex3/login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_amigo = $_GET['id'];

if ($id_usuario == $id_amigo) {
    echo "Você não pode solicitar amizade para você mesmo.";
    exit;
}

$comando = "
    SELECT *
    FROM pendentes
    WHERE id_usuario = :id_usuario
    AND id_amigo = :id_amigo
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':id_usuario' => $id_usuario,
    ':id_amigo' => $id_amigo
]);

if ($stm->fetch()) {

    echo "Solicitação já enviada.";
    exit;
}

$comando = "
    INSERT INTO pendentes
    (id_usuario, id_amigo)
    VALUES
    (:id_usuario, :id_amigo)
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':id_usuario' => $id_usuario,
    ':id_amigo' => $id_amigo
]);

echo "Solicitação de amizade enviada.";

?>