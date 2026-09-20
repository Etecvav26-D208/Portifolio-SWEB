<?php

include("../../conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];

    $sql = "INSERT INTO categorias (nome) VALUES ('$nome')";

    if (mysqli_query($conexao, $sql)) {

        header("Location: listar.php");
        exit;

    } else {

        echo "Erro ao cadastrar categoria.";

    }

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Categoria | SUA PACK</title>

    <link rel="stylesheet" href="../admin.css">

</head>

<body>

<header class="admin-header">

    <div class="logo">
        SUA <span>PACK</span>
    </div>

    <div class="admin-identificacao">

        <strong>
            Cadastrar Categoria
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
            Nova categoria
        </h1>

        <p>
            Cadastre uma nova categoria para os produtos.
        </p>

    </div>


    <form method="POST">

        <label>
            Nome da categoria:
        </label>

        <input
            type="text"
            name="nome"
            placeholder="Exemplo: Mochilas"
            required
        >

        <button type="submit">
            CADASTRAR CATEGORIA
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
