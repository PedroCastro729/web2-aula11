<?php

require("../conexao.php");

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../ex3/login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

$comando = "
    SELECT
        pendentes.id_usuario,
        usuarios.nome,
        usuarios.email
    FROM pendentes
    INNER JOIN usuarios
        ON usuarios.id = pendentes.id_usuario
    WHERE pendentes.id_amigo = :id_usuario
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':id_usuario' => $id_usuario
]);

?>

<h1>Solicitações de amizade</h1>

<?php

while ($usuario = $stm->fetch(PDO::FETCH_ASSOC)) {

    echo "<p>";

    echo $usuario['nome'];
    echo " - ";

    echo "<a href='aprovar.php?id={$usuario['id_usuario']}'>";
    echo "Aprovar";
    echo "</a>";

    echo "</p>";
}

?>