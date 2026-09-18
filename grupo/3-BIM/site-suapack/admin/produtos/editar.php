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


    header("Location: listar.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Editar Produto - SUA PACK</title>

</head>

<body>

    <h1>Editar Produto</h1>


    <form method="POST">


        <label>
            Nome do produto:
        </label>

        <br>

        <input
            type="text"
            name="nome"
            value="<?= $produto["nome"] ?>"
            required
        >

        <br><br>


        <label>
            Descrição:
        </label>

        <br>

        <textarea name="descricao"><?= $produto["descricao"] ?></textarea>

        <br><br>


        <label>
            Preço:
        </label>

        <br>

        <input
            type="number"
            name="preco"
            step="0.01"
            value="<?= $produto["preco"] ?>"
            required
        >

        <br><br>


        <label>
            Preço promocional:
        </label>

        <br>

        <input
            type="number"
            name="preco_promocional"
            step="0.01"
            value="<?= $produto["preco_promocional"] ?>"
        >

        <br><br>


        <label>
            Nome da imagem:
        </label>

        <br>

        <input
            type="text"
            name="imagem"
            value="<?= $produto["imagem"] ?>"
        >

        <br><br>


        <label>
            Estoque:
        </label>

        <br>

        <input
            type="number"
            name="estoque"
            min="0"
            value="<?= $produto["estoque"] ?>"
            required
        >

        <br><br>


        <label>
            Categoria:
        </label>

        <br>

        <select name="id_categoria" required>

            <?php while ($categoria = mysqli_fetch_assoc($categorias)) { ?>

                <option
                    value="<?= $categoria["id_categoria"] ?>"

                    <?php

                    if ($categoria["id_categoria"] == $produto["id_categoria"]) {
                        echo "selected";
                    }

                    ?>
                >

                    <?= $categoria["nome"] ?>

                </option>

            <?php } ?>

        </select>

        <br><br>


        <label>

            <input
                type="checkbox"
                name="em_promocao"

                <?php

                if ($produto["em_promocao"] == 1) {
                    echo "checked";
                }

                ?>
            >

            Produto em promoção

        </label>

        <br><br>


        <button type="submit">
            Salvar Alterações
        </button>


    </form>


    <br>


    <a href="listar.php">
        Voltar para produtos
    </a>


</body>

</html>
