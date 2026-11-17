<?php

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../ex3/login.php");
    exit;
}

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Novo filme</title>
</head>

<body>

<h1>Cadastrar filme</h1>

<p>
    Usuário: <?= $_SESSION['nome'] ?>
</p>

<p>
    Idade: <?= $_SESSION['idade'] ?> anos
</p>

<form action="salva_filme.php"
      method="post"
      enctype="multipart/form-data">

    <label>Nome do filme:</label>
    <input type="text" name="nome" required>

    <br><br>

    <label>Descrição:</label>
    <textarea name="descricao" required></textarea>

    <br><br>

    <label>Foto:</label>
    <input type="file" name="foto" required>

    <br><br>

    <label>Link:</label>
    <input type="url" name="link" required>

    <br><br>

    <label>Classificação:</label>

    <select name="classificacao" required>
        <option value="0">L - Livre</option>
        <option value="10">10 anos</option>
        <option value="12">12 anos</option>
        <option value="14">14 anos</option>
        <option value="16">16 anos</option>
        <option value="18">18 anos</option>
    </select>

    <br><br>

    <label>Nota:</label>
    <input
        type="number"
        name="nota_usuario"
        min="0"
        max="10"
        required
    >

    <br><br>

    <input type="submit" value="Cadastrar filme">

</form>

</body>

</html>