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
    SELECT
        filmes.*,
        usuarios.nome AS dono
    FROM filmes
    INNER JOIN usuarios
        ON usuarios.id = filmes.id_usuario
    WHERE filmes.id = :id_filme
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':id_filme' => $id_filme
]);

$filme = $stm->fetch(PDO::FETCH_ASSOC);

if (!$filme) {
    echo "Filme não encontrado.";
    exit;
}

$comando = "
    SELECT COUNT(*) AS quantidade
    FROM curtidas
    WHERE id_filme = :id_filme
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':id_filme' => $id_filme
]);

$curtidas = $stm->fetch(PDO::FETCH_ASSOC);

?>

<h1>
    <?= htmlspecialchars($filme['nome']) ?>
</h1>

<p>
    Cadastrado por:
    <?= htmlspecialchars($filme['dono']) ?>
</p>

<img
    src="<?= htmlspecialchars($filme['foto']) ?>"
    height="200"
>

<p>
    <?= htmlspecialchars($filme['descricao']) ?>
</p>

<p>
    Classificação:
    <?= $filme['classificacao'] == 0
        ? "L"
        : $filme['classificacao'] . " anos"
    ?>
</p>

<p>
    Nota:
    <?= $filme['nota_usuario'] ?>
</p>

<p>
    ❤️ Curtidas:
    <?= $curtidas['quantidade'] ?>
</p>

<p>
    <a href="curtir.php?id=<?= $id_filme ?>">
        Curtir filme
    </a>
</p>

<hr>

<h2>Comentários</h2>

<?php

$comando = "
    SELECT
        comentarios.comentario,
        usuarios.nome
    FROM comentarios
    INNER JOIN usuarios
        ON usuarios.id = comentarios.id_usuario
    WHERE comentarios.id_filme = :id_filme
    ORDER BY comentarios.id DESC
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':id_filme' => $id_filme
]);

while ($comentario = $stm->fetch(PDO::FETCH_ASSOC)) {

    echo "<p>";

    echo "<strong>";
    echo htmlspecialchars($comentario['nome']);
    echo "</strong>";

    echo ": ";

    echo htmlspecialchars($comentario['comentario']);

    echo "</p>";
}

?>

<hr>

<h2>Novo comentário</h2>

<form action="comentar.php" method="post">

    <input
        type="hidden"
        name="id_filme"
        value="<?= $id_filme ?>"
    >

    <textarea
        name="comentario"
        required
    ></textarea>

    <br><br>

    <input
        type="submit"
        value="Comentar"
    >

</form>

<br>

<a href="<?= htmlspecialchars($filme['link']) ?>">
    Link do filme
</a>