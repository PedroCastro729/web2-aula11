<?php

require("../conexao.php");

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../ex3/login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

$comando = "
    SELECT id, nome, email
    FROM usuarios
    WHERE id != :id_usuario
    AND id NOT IN (
        SELECT id_amigo
        FROM amigos
        WHERE id_usuario = :id_usuario
    )
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':id_usuario' => $id_usuario
]);

?>

<h1>Usuários</h1>

<?php

while ($usuario = $stm->fetch(PDO::FETCH_ASSOC)) {

    echo "<p>";
    echo $usuario['nome'];
    echo " - ";
    echo $usuario['email'];
    echo " ";

    echo "<a href='solicitar.php?id={$usuario['id']}'>";
    echo "Solicitar amizade";
    echo "</a>";

    echo "</p>";
}

?>

<br>

<a href="pendentes.php">
    Ver solicitações pendentes
</a>