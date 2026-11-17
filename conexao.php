<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "barrefertas";

$conexao = new PDO(
    "mysql:host=$servidor;dbname=$banco;charset=utf8mb4",
    $usuario,
    $senha
);

$conexao->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);

?>