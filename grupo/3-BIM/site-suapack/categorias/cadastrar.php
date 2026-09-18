<?php

include("../../conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];

    $sql = "INSERT INTO categorias (nome) VALUES ('$nome')";

    mysqli_query($conexao, $sql);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastrar Categoria - SUA PACK</title>
</head>

<body>

    <h1>Cadastrar Categoria</h1>

    <form method="POST">

        <label>Nome da categoria:</label>

        <input type="text" name="nome" required>

        <button type="submit">Cadastrar</button>

    </form>

</body>

</html>
