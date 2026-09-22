<?php

include("../../conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome_cliente = $_POST["nome_cliente"];
    $endereco = $_POST["endereco"];
    $forma_pagamento = $_POST["forma_pagamento"];
    $valor_total = $_POST["valor_total"];
    $status_pedido = $_POST["status_pedido"];


    $sql = "
        INSERT INTO pedidos
        (
            nome_cliente,
            endereco,
            forma_pagamento,
            valor_total,
            status_pedido
        )

        VALUES
        (
            '$nome_cliente',
            '$endereco',
            '$forma_pagamento',
            '$valor_total',
            '$status_pedido'
        )
    ";


    if (mysqli_query($conexao, $sql)) {

        header("Location: listar.php");
        exit;

    } else {

        echo "Erro ao cadastrar pedido.";

    }

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
        Cadastrar Pedido | SUA PACK
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
            Cadastrar Pedido
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
            Novo pedido
        </h1>

        <p>
            Cadastre um novo pedido da SUA PACK.
        </p>

    </div>


    <form method="POST">


        <label>
            Nome do cliente:
        </label>

        <input
            type="text"
            name="nome_cliente"
            required
        >


        <label>
            Endereço:
        </label>

        <input
            type="text"
            name="endereco"
            required
        >


        <label>
            Forma de pagamento:
        </label>

        <select
            name="forma_pagamento"
            required
        >

            <option value="">
                Selecione
            </option>

            <option value="Pix">
                Pix
            </option>

            <option value="Cartão">
                Cartão
            </option>

            <option value="Boleto">
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
            required
        >


        <label>
            Status do pedido:
        </label>

        <select
            name="status_pedido"
            required
        >

            <option value="Pendente">
                Pendente
            </option>

            <option value="Em preparação">
                Em preparação
            </option>

            <option value="Enviado">
                Enviado
            </option>

            <option value="Entregue">
                Entregue
            </option>

        </select>


        <button type="submit">
            CADASTRAR PEDIDO
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
