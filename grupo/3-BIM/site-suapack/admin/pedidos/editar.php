<?php

include("../../conexao.php");

$id = $_GET["id"];


/* Busca o pedido */

$sql = "SELECT * FROM pedidos WHERE id_pedido = $id";

$resultado = mysqli_query($conexao, $sql);

$pedido = mysqli_fetch_assoc($resultado);


/* Atualiza o pedido */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome_cliente = $_POST["nome_cliente"];
    $endereco = $_POST["endereco"];
    $forma_pagamento = $_POST["forma_pagamento"];
    $valor_total = $_POST["valor_total"];
    $status_pedido = $_POST["status_pedido"];


    $sql = "
        UPDATE pedidos SET

            nome_cliente = '$nome_cliente',
            endereco = '$endereco',
            forma_pagamento = '$forma_pagamento',
            valor_total = '$valor_total',
            status_pedido = '$status_pedido'

        WHERE id_pedido = $id
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

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Editar Pedido | SUA PACK
    </title>

    <link rel="stylesheet" href="../admin.css">

</head>


<body>


<header class="admin-header">

    <div class="logo">
        SUA <span>PACK</span>
    </div>

    <div class="admin-identificacao">

        <strong>
            Editar Pedido
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
            Editar pedido
        </h1>

        <p>
            Altere as informações do pedido.
        </p>

    </div>


    <form method="POST">


        <label>
            Nome do cliente:
        </label>

        <input
            type="text"
            name="nome_cliente"
            value="<?= htmlspecialchars($pedido["nome_cliente"]) ?>"
            required
        >


        <label>
            Endereço:
        </label>

        <input
            type="text"
            name="endereco"
            value="<?= htmlspecialchars($pedido["endereco"]) ?>"
            required
        >


        <label>
            Forma de pagamento:
        </label>

        <select
            name="forma_pagamento"
            required
        >

            <option
                value="Pix"
                <?= $pedido["forma_pagamento"] == "Pix" ? "selected" : "" ?>
            >
                Pix
            </option>

            <option
                value="Cartão"
                <?= $pedido["forma_pagamento"] == "Cartão" ? "selected" : "" ?>
            >
                Cartão
            </option>

            <option
                value="Boleto"
                <?= $pedido["forma_pagamento"] == "Boleto" ? "selected" : "" ?>
            >
                Boleto
            </option>

        </select>


        <label>
            Valor total:
        </label>

        <input
            type="number"
            name="valor_total"
            step="0.01"
            min="0"
            value="<?= $pedido["valor_total"] ?>"
            required
        >


        <label>
            Status do pedido:
        </label>

        <select
            name="status_pedido"
            required
        >

            <option
                value="Pendente"
                <?= $pedido["status_pedido"] == "Pendente" ? "selected" : "" ?>
            >
                Pendente
            </option>

            <option
                value="Em preparação"
                <?= $pedido["status_pedido"] == "Em preparação" ? "selected" : "" ?>
            >
                Em preparação
            </option>

            <option
                value="Enviado"
                <?= $pedido["status_pedido"] == "Enviado" ? "selected" : "" ?>
            >
                Enviado
            </option>

            <option
                value="Entregue"
                <?= $pedido["status_pedido"] == "Entregue" ? "selected" : "" ?>
            >
                Entregue
            </option>

        </select>


        <button type="submit">
            SALVAR ALTERAÇÕES
        </button>


    </form>


    <br>


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
