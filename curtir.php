<?php

require("../conexao.php");

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../ex3/login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_filme = $_GET['id'];

$comando = "
    SELECT *
    FROM curtidas
    WHERE id_usuario = :id_usuario
    AND id_filme = :id_filme
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':id_usuario' => $id_usuario,
    ':id_filme' => $id_filme
]);

if ($stm->fetch()) {

    echo "Você já curtiu este filme.";

    exit;
}

$comando = "
    INSERT INTO curtidas
    (id_usuario, id_filme)
    VALUES
    (:id_usuario, :id_filme)
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':id_usuario' => $id_usuario,
    ':id_filme' => $id_filme
]);

header("Location: detalhe_filme.php?id=" . $id_filme);

?>