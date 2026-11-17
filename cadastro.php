<!DOCTYPE html>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>

<body>

<h1>Cadastro de usuário</h1>

<form action="salva.php" method="post">

    <label>Nome:</label>
    <input type="text" name="nome" required>

    <br><br>

    <label>E-mail:</label>
    <input type="email" name="email" required>

    <br><br>

    <label>Data de nascimento:</label>
    <input type="date" name="nascimento" required>

    <br><br>

    <label>Senha:</label>
    <input type="password" name="senha" required>

    <br><br>

    <input type="submit" value="Cadastrar">

</form>

</body>

</html>