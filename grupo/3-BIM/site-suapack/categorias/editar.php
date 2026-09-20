<?php

include("../../conexao.php");

$id = $_GET["id"];


/* Busca a categoria */

$sql = "SELECT * FROM categorias WHERE id_categoria = $id";

$resultado = mysqli_query($conexao, $sql);

$categoria = mysqli_fetch_assoc($resultado);


/* Atualiza a categoria */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];

    $sql = "
        UPDATE categorias
        SET nome = '$nome'
        WHERE id_categoria = $id
    ";

    mysqli_query($conexao, $sql);

    header("Location: listar.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Categoria | SUA PACK</title>

    <link rel="stylesheet" href="../admin.css">

</head>

<body>

<header class="admin-header">

    <div class="logo">
        SUA <span>PACK</span>
    </div>

    <div class="admin-identificacao">

        <strong>
            Editar Categoria
        </strong>

        <span class="status">
            Área Administrativa
        </span>

    </div>

    <a href="../index.php" class="voltar-site">
        ← Painel
    </a>

</header>


<main class="admin-container">

    <div class="boas-vindas">

        <h1>
            Editar categoria
        </h1>

        <p>
            Altere o nome da categoria.
        </p>

    </div>


    <form method="POST">

        <label>
            Nome da categoria:
        </label>

        <input
            type="text"
            name="nome"
            value="<?= htmlspecialchars($categoria["nome"]) ?>"
            required
        >

        <button type="submit">
            SALVAR ALTERAÇÕES
        </button>

    </form>


    <br>

    <a href="listar.php">
        ← Voltar para categorias
    </a>

</main>


<footer class="admin-footer">

    <p>
        SUA PACK — Área Administrativa
    </p>

</footer>

</body>

</html>
