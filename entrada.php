<?php

require("../conexao.php");

$email = $_POST['email'];
$senha = $_POST['senha'];

$senha = hash("sha256", $senha);

$comando = "
    SELECT *
    FROM usuarios
    WHERE email = :email
    AND senha = :senha
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':email' => $email,
    ':senha' => $senha
]);

$usuario = $stm->fetch(PDO::FETCH_ASSOC);

if ($usuario) {

    $nascimento = new DateTime($usuario['nascimento']);
    $hoje = new DateTime();

    $idade = $hoje->diff($nascimento)->y;

    session_start();

    $_SESSION['id_usuario'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['idade'] = $idade;

    echo "Bem-vindo, {$usuario['nome']}!";

    echo "<br><br>";

    echo "<a href='../ex4/novo_filme.php'>Cadastrar filme</a>";

} else {

    echo "E-mail ou senha incorretos.";

}

?>