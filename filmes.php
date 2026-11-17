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
        filmes.*,
        usuarios.nome AS dono,
        (
            SELECT COUNT(*)
            FROM curtidas
            WHERE curtidas.id_filme = filmes.id
        ) AS quantidade_curtidas
    FROM filmes
    INNER JOIN usuarios
        ON usuarios.id = filmes.id_usuario
    WHERE filmes.id_usuario IN (
        SELECT id_amigo
        FROM amigos
        WHERE id_usuario = :id_usuario
    )
    ORDER BY filmes.id DESC
";

$stm = $conexao->prepare($comando);

$stm->execute([
    ':id_usuario' => $id_usuario
]);

?>

<h1>Filmes dos meus amigos</h1>

<?php

while ($filme = $stm->fetch(PDO::FETCH_ASSOC)) {

?>

    <div>

        <h2>
            <?= htmlspecialchars($filme['nome']) ?>
        </h2>

        <p>
            Cadastrado por:
            <?= htmlspecialchars($filme['dono']) ?>
        </p>

        <img
            src="<?= htmlspecialchars($filme['foto']) ?>"
            height="150"
        >

        <p>
            <?= htmlspecialchars($filme['descricao']) ?>
        </p>

        <p>
            ❤️ Curtidas:
            <?= $filme['quantidade_curtidas'] ?>
        </p>

        <a href="detalhe_filme.php?id=<?= $filme['id'] ?>">
            Ver detalhes
        </a>

    </div>

    <hr>

<?php

}

?>