<?php

include("../../conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome_cliente = $_POST["nome_cliente"];
    $endereco = $_POST["endereco"];
    $forma_pagamento = $_POST["forma_pagamento"];
    $valor_total = $_POST["valor_total"];
    $status_pedido = $_POST["status_pedido"];

    $sql = "INSERT INTO pedidos
            (nome_cliente, endereco, forma_pagamento, valor_total, status_pedido)
            VALUES
            ('$nome_cliente', '$endereco', '$forma_pagamento', '$valor_total', '$status_pedido')";

    mysqli_query($conexao, $sql);

    header("Location: listar.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Cadastrar Pedido - SUA PACK</title>

</head>

<body>

    <h1>Cadastrar Pedido</h1>

    <form method="POST">

        <label>Nome do cliente:</label>
        <br>

        <input
            type="text"
            name="nome_cliente"
            required
        >

        <br><br>


        <label>Endereço:</label>
        <br>

        <input
            type="text"
            name="endereco"
            required
        >

        <br><br>


        <label>Forma de pagamento:</label>
        <br>

        <select name="forma_pagamento" required>

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

        <br><br>


        <label>Valor total:</label>
        <br>

        <input
            type="number"
            name="valor_total"
            step="0.01"
            min="0"
            required
        >

        <br><br>


        <label>Status do pedido:</label>
        <br>

        <select name="status_pedido" required>

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

            <option value="Cancelado">
                Cancelado
            </option>

        </select>

        <br><br>


        <button type="submit">
            Cadastrar Pedido
        </button>

    </form>

    <br>

    <a href="listar.php">
        Voltar para pedidos
    </a>

</body>

</html>
