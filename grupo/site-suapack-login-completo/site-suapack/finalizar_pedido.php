<?php
require_once "includes/auth.php";
require_once "conexao.php";

exigir_login("login.php?redirect=checkout.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST" || empty($_SESSION["carrinho"])) {
    header("Location: carrinho.php");
    exit;
}

$nome_cliente = trim($_POST["nome_cliente"] ?? "");
$endereco = trim($_POST["endereco"] ?? "");
$cep = trim($_POST["cep"] ?? "");
$complemento = trim($_POST["complemento"] ?? "");
$forma_pagamento = trim($_POST["forma_pagamento"] ?? "");

$pagamentos_validos = ["Pix", "Cartão de crédito", "Boleto"];

if ($nome_cliente === "" || $endereco === "" || $cep === "" || !in_array($forma_pagamento, $pagamentos_validos, true)) {
    header("Location: checkout.php");
    exit;
}

$endereco_completo = $endereco . " | CEP: " . $cep;
if ($complemento !== "") {
    $endereco_completo .= " | Complemento: " . $complemento;
}

try {
    $conexao->begin_transaction();

    $itens = [];
    $total = 0.0;
    $stmt_produto = $conexao->prepare("SELECT id_produto, preco, preco_promocional, estoque, em_promocao FROM produtos WHERE id_produto = ? FOR UPDATE");

    foreach ($_SESSION["carrinho"] as $id_produto => $quantidade) {
        $id_produto = (int) $id_produto;
        $quantidade = (int) $quantidade;
        if ($id_produto <= 0 || $quantidade <= 0) continue;

        $stmt_produto->bind_param("i", $id_produto);
        $stmt_produto->execute();
        $produto = $stmt_produto->get_result()->fetch_assoc();
        if (!$produto || (int)$produto["estoque"] < $quantidade) {
            throw new RuntimeException("Um dos produtos não possui estoque suficiente.");
        }

        $preco = ((int)$produto["em_promocao"] === 1 && $produto["preco_promocional"] !== null && (float)$produto["preco_promocional"] > 0)
            ? (float)$produto["preco_promocional"]
            : (float)$produto["preco"];

        $total += $preco * $quantidade;
        $itens[] = ["id_produto" => $id_produto, "quantidade" => $quantidade, "preco" => $preco];
    }
    $stmt_produto->close();

    if (!$itens || $total <= 0) throw new RuntimeException("Carrinho vazio.");

    $id_usuario = id_usuario_logado();
    $stmt_pedido = $conexao->prepare("INSERT INTO pedidos (id_usuario, nome_cliente, endereco, forma_pagamento, valor_total, status_pedido) VALUES (?, ?, ?, ?, ?, 'Pendente')");
    $stmt_pedido->bind_param("isssd", $id_usuario, $nome_cliente, $endereco_completo, $forma_pagamento, $total);
    $stmt_pedido->execute();
    $id_pedido = $conexao->insert_id;
    $stmt_pedido->close();

    $stmt_item = $conexao->prepare("INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
    $stmt_estoque = $conexao->prepare("UPDATE produtos SET estoque = estoque - ? WHERE id_produto = ? AND estoque >= ?");

    foreach ($itens as $item) {
        $id_produto = $item["id_produto"];
        $quantidade = $item["quantidade"];
        $preco = $item["preco"];
        $stmt_item->bind_param("iiid", $id_pedido, $id_produto, $quantidade, $preco);
        $stmt_item->execute();

        $stmt_estoque->bind_param("iii", $quantidade, $id_produto, $quantidade);
        $stmt_estoque->execute();
        if ($stmt_estoque->affected_rows !== 1) throw new RuntimeException("Não foi possível atualizar o estoque.");
    }
    $stmt_item->close();
    $stmt_estoque->close();

    $conexao->commit();
    unset($_SESSION["carrinho"]);
    header("Location: pedido_confirmado.php?id=" . $id_pedido);
    exit;
} catch (Throwable $erro) {
    if ($conexao->errno === 0 || $conexao->in_transaction) {
        $conexao->rollback();
    }
    http_response_code(400);
    exit("Não foi possível finalizar o pedido. Verifique o estoque e tente novamente.");
}
?>
