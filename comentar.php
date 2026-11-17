<?php

require("../conexao.php");

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../ex3/login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$id_filme = $_POST['id_filme'];
$comentario = trim($_POST['comentario']);

if ($comentario == "") {
    echo "O comentário não pode estar vazio.";
    exit;
}

$comando = "
    SELECT filmes.id
    FROM filmes
    INNER JOIN amigos
        ON amigos.id_amigo = filmes.id_usuario
    WHERE filmes.id = :id_filme
    AND amigos.id_usuario = :id_usuario
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':id_filme' => $id_filme,
    ':id_usuario' => $id_usuario
]);

if (!$stm->fetch()) {

    echo "Você só pode comentar em filmes cadastrados por amigos.";

    exit;
}

$comando = "
    INSERT INTO comentarios
    (id_usuario, id_filme, comentario)
    VALUES
    (:id_usuario, :id_filme, :comentario)
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':id_usuario' => $id_usuario,
    ':id_filme' => $id_filme,
    ':comentario' => $comentario
]);

header("Location: detalhe_filme.php?id=" . $id_filme);

?>