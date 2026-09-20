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

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Visualizar Pedido - SUA PACK
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
            Visualizar Pedido
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
            Detalhes do pedido
        </h1>

        <p>
            Confira todas as informações deste pedido.
        </p>

    </div>



    <div class="admin-info">


        <p class="info-texto">

            <strong>
                ID do pedido:
            </strong>

            <?= $pedido["id_pedido"] ?>

        </p>



        <p class="info-texto">

            <strong>
                Nome do cliente:
            </strong>

            <?= htmlspecialchars($pedido["nome_cliente"]) ?>

        </p>



        <p class="info-texto">

            <strong>
                Endereço:
            </strong>

            <?= htmlspecialchars($pedido["endereco"]) ?>

        </p>



        <p class="info-texto">

            <strong>
                Forma de pagamento:
            </strong>

            <?= htmlspecialchars($pedido["forma_pagamento"]) ?>

        </p>



        <p class="info-texto">

            <strong>
                Valor total:
            </strong>

            R$

            <?= number_format(
                $pedido["valor_total"],
                2,
                ",",
                "."
            ) ?>

        </p>



        <p class="info-texto">

            <strong>
                Status do pedido:
            </strong>

            <?= htmlspecialchars($pedido["status_pedido"]) ?>

        </p>


    </div>



    <br>


    <a
        href="editar.php?id=<?= $pedido["id_pedido"] ?>"
    >

        Editar pedido

    </a>


    <br><br>


    <a href="listar.php">

        ← Voltar para pedidos

    </a>


</main>



<footer class="admin-footer">

    <p>

        SUA PACK — Área Administrativa

    </p>

</footer>


</body>

</html>
