<?php

include("../../conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $preco_promocional = $_POST["preco_promocional"];
    $imagem = $_POST["imagem"];
    $estoque = $_POST["estoque"];
    $id_categoria = $_POST["id_categoria"];

    if (isset($_POST["em_promocao"])) {
        $em_promocao = 1;
    } else {
        $em_promocao = 0;
    }

    $sql = "
        INSERT INTO produtos
        (
            nome,
            descricao,
            preco,
            preco_promocional,
            imagem,
            estoque,
            em_promocao,
            id_categoria
        )
        VALUES
        (
            '$nome',
            '$descricao',
            '$preco',
            '$preco_promocional',
            '$imagem',
            '$estoque',
            '$em_promocao',
            '$id_categoria'
        )
    ";

    if (mysqli_query($conexao, $sql)) {

        header("Location: listar.php");
        exit;

    } else {

        echo "Erro ao cadastrar produto.";

    }

}

$sql_categorias = "
    SELECT *
    FROM categorias
    ORDER BY nome ASC
";

$resultado_categorias = mysqli_query(
    $conexao,
    $sql_categorias
);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Produto | SUA PACK</title>

    <link rel="stylesheet" href="../admin.css">

</head>

<body>


<header class="admin-header">

    <div class="logo">
        SUA <span>PACK</span>
    </div>

    <div class="admin-identificacao">

        <strong>
            Cadastrar Produto
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
            Novo produto
        </h1>

        <p>
            Cadastre um novo produto da SUA PACK.
        </p>

    </div>



    <form method="POST">


        <label>
            Nome do produto
        </label>

        <input
            type="text"
            name="nome"
            required
        >



        <label>
            Descrição
        </label>

        <textarea
            name="descricao"
            rows="5"
        ></textarea>



        <label>
            Preço
        </label>

        <input
            type="number"
            name="preco"
            step="0.01"
            required
        >



        <label>
            Preço promocional
        </label>

        <input
            type="number"
            name="preco_promocional"
            step="0.01"
        >



        <label>
            Categoria
        </label>

        <select
            name="id_categoria"
            required
        >

            <option value="">
                Selecione uma categoria
            </option>


            <?php while ($categoria = mysqli_fetch_assoc($resultado_categorias)) { ?>

                <option
                    value="<?= $categoria["id_categoria"] ?>"
                >

                    <?= htmlspecialchars($categoria["nome"]) ?>

                </option>

            <?php } ?>

        </select>



        <label>
            Imagem
        </label>

        <input
            type="text"
            name="imagem"
            placeholder="exemplo.jpg"
        >



        <label>
            Estoque
        </label>

        <input
            type="number"
            name="estoque"
            min="0"
            value="0"
            required
        >



        <label>

            <input
                type="checkbox"
                name="em_promocao"
                value="1"
            >

            Produto em promoção

        </label>



        <button type="submit">
            CADASTRAR PRODUTO
        </button>


    </form>


</main>


</body>

</html>
