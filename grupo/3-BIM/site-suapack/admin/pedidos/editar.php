<?php

include("../../conexao.php");

$id = $_GET["id"];


/* Busca o pedido */

$sql = "SELECT * FROM pedidos WHERE id_pedido = $id";

$resultado = mysqli_query($conexao, $sql);

$pedido = mysqli_fetch_assoc($resultado);


/* Quando o formulário for enviado */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome_cliente = $_POST["nome_cliente"];
    $endereco = $_POST["endereco"];
    $forma_pagamento = $_POST["forma_pagamento"];
    $valor_total = $_POST["valor_total"];
    $status_pedido = $_POST["status_pedido"];


    $sql = "UPDATE pedidos SET

            nome_cliente = '$nome_cliente',
            endereco = '$endereco',
            forma_pagamento = '$forma_pagamento',
            valor_total = '$valor_total',
            status_pedido = '$status_pedido'

            WHERE id_pedido = $id";


    mysqli_query($conexao, $sql);


    header("Location: listar.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Editar Pedido - SUA PACK</title>

</head>

<body>

    <h1>Editar Pedido</h1>


    <form method="POST">


        <label>
            Nome do cliente:
        </label>

        <br>

        <input
            type="text"
            name="nome_cliente"
            value="<?= $pedido["nome_cliente"] ?>"
            required
        >

        <br><br>


        <label>
            Endereço:
        </label>

        <br>

        <input
            type="text"
            name="endereco"
            value="<?= $pedido["endereco"] ?>"
            required
        >

        <br><br>


        <label>
            Forma de pagamento:
        </label>

        <br>

        <select name="forma_pagamento" required>

            <option value="Pix"
                <?= $pedido["forma_pagamento"] == "Pix" ? "selected" : "" ?>>
                Pix
            </option>

            <option value="Cartão"
                <?= $pedido["forma_pagamento"] == "Cartão" ? "selected" : "" ?>>
                Cartão
            </option>

            <option value="Boleto"
                <?= $pedido["forma_pagamento"] == "Boleto" ? "selected" : "" ?>>
                Boleto
            </option>

        </select>

        <br><br>


        <label>
            Valor total:
        </label>

        <br>

        <input
            type="number"
            name="valor_total"
            step="0.01"
            min="0"
            value="<?= $pedido["valor_total"] ?>"
            required
        >

        <br><br>


        <label>
            Status do pedido:
        </label>

        <br>

        <select name="status_pedido" required>

            <option value="Pendente"
                <?= $pedido["status_pedido"] == "Pendente" ? "selected" : "" ?>>
                Pendente
            </option>

            <option value="Em preparação"
                <?= $pedido["status_pedido"] == "Em preparação" ? "selected" : "" ?>>
                Em preparação
            </option>

            <option value="Enviado"
                <?= $pedido["status_pedido"] == "Enviado" ? "selected" : "" ?>>
                Enviado
            </option>

            <option value="Entregue"
                <?= $pedido["status_pedido"] == "Entregue" ? "selected" : "" ?>>
                Entregue
            </option>

            <option value="Cancelado"
                <?= $pedido["status_pedido"] == "Cancelado" ? "selected" : "" ?>>
                Cancelado
            </option>

        </select>

        <br><br>


        <button type="submit">
            Salvar Alterações
        </button>


    </form>


    <br>


    <a href="listar.php">
        Voltar para pedidos
    </a>

</body>

</html>
