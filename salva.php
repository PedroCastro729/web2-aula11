<?php

require("../conexao.php");

$nome = $_POST['nome'];
$email = $_POST['email'];
$nascimento = $_POST['nascimento'];
$senha = $_POST['senha'];

$senha = hash("sha256", $senha);

$comando = "
    INSERT INTO usuarios
    (nome, email, nascimento, senha)
    VALUES
    (:nome, :email, :nascimento, :senha)
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':nome' => $nome,
    ':email' => $email,
    ':nascimento' => $nascimento,
    ':senha' => $senha
]);

echo "Usuário cadastrado com sucesso!";

?>