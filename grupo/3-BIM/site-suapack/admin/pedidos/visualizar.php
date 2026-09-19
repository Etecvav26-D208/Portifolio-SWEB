<?php

include("../../conexao.php");

$id = $_GET["id"];


/* Busca o pedido */

$sql = "SELECT * FROM pedidos WHERE id_pedido = $id";

$resultado = mysqli_query($conexao, $sql);

$pedido = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Visualizar Pedido - SUA PACK</title>

</head>

<body>

    <h1>Detalhes do Pedido</h1>


    <p>
        <strong>ID do pedido:</strong>
        <?= $pedido["id_pedido"] ?>
    </p>


    <p>
        <strong>Nome do cliente:</strong>
        <?= $pedido["nome_cliente"] ?>
    </p>


    <p>
        <strong>Endereço:</strong>
        <?= $pedido["endereco"] ?>
    </p>


    <p>
        <strong>Forma de pagamento:</strong>
        <?= $pedido["forma_pagamento"] ?>
    </p>


    <p>
        <strong>Valor total:</strong>
        R$ <?= $pedido["valor_total"] ?>
    </p>


    <p>
        <strong>Status do pedido:</strong>
        <?= $pedido["status_pedido"] ?>
    </p>


    <br>


    <a href="editar.php?id=<?= $pedido["id_pedido"] ?>">
        Editar pedido
    </a>


    <br><br>


    <a href="listar.php">
        Voltar para pedidos
    </a>

</body>

</html>
