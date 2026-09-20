<?php

include("../../conexao.php");

$id = $_GET["id"];


/* Busca o produto que será editado */

$sql = "SELECT * FROM produtos WHERE id_produto = $id";

$resultado = mysqli_query($conexao, $sql);

$produto = mysqli_fetch_assoc($resultado);


/* Busca as categorias para o menu */

$categorias = mysqli_query(
    $conexao,
    "SELECT * FROM categorias ORDER BY nome"
);


/* Quando o formulário for enviado */

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


    /* Atualiza o produto */

    $sql = "UPDATE produtos SET

        nome = '$nome',
        descricao = '$descricao',
        preco = '$preco',
        preco_promocional = '$preco_promocional',
        imagem = '$imagem',
        estoque = '$estoque',
        em_promocao = '$em_promocao',
        id_categoria = '$id_categoria'

        WHERE id_produto = $id";


    mysqli_query($conexao, $sql);


    /* Volta para a lista de produtos */

    header("Location: listar.php");

    exit;

}

?>


<!DOCTYPE html>

<html lang="pt-BR">


<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Editar Produto - SUA PACK
    </title>

    <link
        rel="stylesheet"
        href="../admin.css"
    >

</head>


<body>


<header class="admin-header">


    <div class="logo">

        SUA <span>PACK</span>

    </div>


    <div class="admin-identificacao">

        <strong>
            Editar Produto
        </strong>

        <span class="status">
            Área Administrativa
        </span>

    </div>


    <a
        href="../index.php"
        class="voltar-site"
    >
        ← Painel
    </a>


</header>



<main class="admin-container">


    <div class="boas-vindas">

        <h1>
            Editar produto
        </h1>

        <p>
            Altere as informações do produto abaixo.
        </p>

    </div>



    <form method="POST">


        <!-- NOME -->

        <label>

            Nome do produto:

        </label>


        <input
            type="text"
            name="nome"
            value="<?= htmlspecialchars($produto["nome"]) ?>"
            required
        >



        <!-- DESCRIÇÃO -->

        <label>

            Descrição:

        </label>


        <textarea
            name="descricao"
            rows="5"
        ><?= htmlspecialchars($produto["descricao"]) ?></textarea>



        <!-- PREÇO -->

        <label>

            Preço:

        </label>


        <input
            type="number"
            name="preco"
            step="0.01"
            value="<?= $produto["preco"] ?>"
            required
        >



        <!-- PREÇO PROMOCIONAL -->

        <label>

            Preço promocional:

        </label>


        <input
            type="number"
            name="preco_promocional"
            step="0.01"
            value="<?= $produto["preco_promocional"] ?>"
        >



        <!-- IMAGEM -->

        <label>

            Nome da imagem:

        </label>


        <input
            type="text"
            name="imagem"
            value="<?= htmlspecialchars($produto["imagem"]) ?>"
            placeholder="exemplo.jpg"
        >



        <!-- ESTOQUE -->

        <label>

            Estoque:

        </label>


        <input
            type="number"
            name="estoque"
            min="0"
            value="<?= $produto["estoque"] ?>"
            required
        >



        <!-- CATEGORIA -->

        <label>

            Categoria:

        </label>


        <select
            name="id_categoria"
            required
        >


            <option value="">

                Selecione uma categoria

            </option>


            <?php while ($categoria = mysqli_fetch_assoc($categorias)) { ?>


                <option
                    value="<?= $categoria["id_categoria"] ?>"

                    <?php

                    if (
                        $categoria["id_categoria"]
                        ==
                        $produto["id_categoria"]
                    ) {

                        echo "selected";

                    }

                    ?>
                >

                    <?= htmlspecialchars($categoria["nome"]) ?>

                </option>


            <?php } ?>


        </select>



        <!-- PROMOÇÃO -->

        <label>


            <input
                type="checkbox"
                name="em_promocao"
                value="1"

                <?php

                if ($produto["em_promocao"] == 1) {

                    echo "checked";

                }

                ?>
            >


            Produto em promoção


        </label>



        <!-- BOTÃO -->

        <button type="submit">

            SALVAR ALTERAÇÕES

        </button>


    </form>



    <br>


    <a href="listar.php">

        ← Voltar para produtos

    </a>


</main>



<footer class="admin-footer">

    <p>

        SUA PACK — Área Administrativa

    </p>

</footer>


</body>

</html>
