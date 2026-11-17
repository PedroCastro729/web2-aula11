<?php

require("../conexao.php");

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../ex3/login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$idade = $_SESSION['idade'];

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$link = $_POST['link'];
$classificacao = (int) $_POST['classificacao'];
$nota_usuario = (int) $_POST['nota_usuario'];

if ($classificacao > $idade) {

    echo "Você não pode cadastrar um filme com classificação maior que sua idade.";

    exit;
}

$nome_original = $_FILES['foto']['name'];
$nome_tmp = $_FILES['foto']['tmp_name'];

$destino = "../imagens/" . basename($nome_original);

move_uploaded_file($nome_tmp, $destino);

$comando = "
    INSERT INTO filmes
    (
        id_usuario,
        nome,
        descricao,
        foto,
        link,
        classificacao,
        nota_usuario
    )
    VALUES
    (
        :id_usuario,
        :nome,
        :descricao,
        :foto,
        :link,
        :classificacao,
        :nota_usuario
    )
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':id_usuario' => $id_usuario,
    ':nome' => $nome,
    ':descricao' => $descricao,
    ':foto' => $destino,
    ':link' => $link,
    ':classificacao' => $classificacao,
    ':nota_usuario' => $nota_usuario
]);

echo "Filme cadastrado com sucesso!";

?>