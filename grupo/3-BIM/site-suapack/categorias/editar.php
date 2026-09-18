<?php

include("../../conexao.php");

$id = $_GET["id"];

$sql = "SELECT * FROM categorias WHERE id_categoria = $id";

$resultado = mysqli_query($conexao, $sql);

$categoria = mysqli_fetch_assoc($resultado);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];

    $sql = "UPDATE categorias 
            SET nome = '$nome' 
            WHERE id_categoria = $id";

    mysqli_query($conexao, $sql);

    header("Location: listar.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Categoria - SUA PACK</title>
</head>

<body>

    <h1>Editar Categoria</h1>

    <form method="POST">

        <label>Nome da categoria:</label>

        <input 
            type="text" 
            name="nome" 
            value="<?= $categoria["nome"] ?>" 
            required
        >

        <button type="submit">
            Salvar Alterações
        </button>

    </form>

    <br>

    <a href="listar.php">
        Voltar para categorias
    </a>

</body>

</html>
