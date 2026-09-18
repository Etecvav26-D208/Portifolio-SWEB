<?php

include("../../conexao.php");

$categorias = mysqli_query($conexao, "SELECT * FROM categorias ORDER BY nome");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $preco_promocional = $_POST["preco_promocional"];
    $imagem = $_POST["imagem"];
    $estoque = $_POST["estoque"];
    $em_promocao = isset($_POST["em_promocao"]) ? 1 : 0;
    $id_categoria = $_POST["id_categoria"];

    $sql = "INSERT INTO produtos 
            (nome, descricao, preco, preco_promocional, imagem, estoque, em_promocao, id_categoria)
            VALUES 
            ('$nome', '$descricao', '$preco', '$preco_promocional', '$imagem', '$estoque', '$em_promocao', '$id_categoria')";

    mysqli_query($conexao, $sql);

    header("Location: listar.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <title>Cadastrar Produto - SUA PACK</title>
</head>

<body>

    <h1>Cadastrar Produto</h1>

    <form method="POST">

        <label>Nome do produto:</label>
        <br>

        <input type="text" name="nome" required>

        <br><br>


        <label>Descrição:</label>
        <br>

        <textarea name="descricao"></textarea>

        <br><br>


        <label>Preço:</label>
        <br>

        <input type="number" name="preco" step="0.01" required>

        <br><br>


        <label>Preço promocional:</label>
        <br>

        <input type="number" name="preco_promocional" step="0.01">

        <br><br>


        <label>Nome da imagem:</label>
        <br>

        <input 
            type="text" 
            name="imagem" 
            placeholder="exemplo.jpg"
        >

        <br><br>


        <label>Estoque:</label>
        <br>

        <input type="number" name="estoque" min="0" required>

        <br><br>


        <label>Categoria:</label>
        <br>

        <select name="id_categoria" required>

            <option value="">Selecione uma categoria</option>

            <?php while ($categoria = mysqli_fetch_assoc($categorias)) { ?>

                <option value="<?= $categoria["id_categoria"] ?>">
                    <?= $categoria["nome"] ?>
                </option>

            <?php } ?>

        </select>

        <br><br>


        <label>

            <input 
                type="checkbox" 
                name="em_promocao"
            >

            Produto em promoção

        </label>

        <br><br>


        <button type="submit">
            Cadastrar Produto
        </button>

    </form>

    <br>

    <a href="listar.php">
        Voltar para produtos
    </a>

</body>

</html>
