<?php

require_once "includes/auth.php";
require_once "conexao.php";

exigir_login("login.php");


if (
    !isset($_GET["id"]) ||
    !is_numeric($_GET["id"])
) {

    header("Location: index.php");

    exit;
}


$id_pedido = intval($_GET["id"]);


$sql = "SELECT * FROM pedidos WHERE id_pedido = ?" . (usuario_admin() ? "" : " AND id_usuario = ?");
$stmt = $conexao->prepare($sql);
if (usuario_admin()) {
    $stmt->bind_param("i", $id_pedido);
} else {
    $id_usuario = id_usuario_logado();
    $stmt->bind_param("ii", $id_pedido, $id_usuario);
}
$stmt->execute();
$resultado = $stmt->get_result();


if ($resultado->num_rows === 0) {

    header("Location: index.php");

    exit;
}


$pedido = mysqli_fetch_assoc(
    $resultado
);

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Pedido confirmado | SUA PACK</title>

    <link rel="stylesheet" href="style.css">

    <style>
        .confirmacao{min-height:100vh;display:flex;justify-content:center;align-items:center;padding:70px 20px;background:radial-gradient(circle at 50% 15%,rgba(183,255,0,.08),transparent 32%)}
        .confirmacao-card{position:relative;max-width:760px;width:100%;text-align:center;background:linear-gradient(145deg,#151515,#0d0d0d);color:#fff;padding:58px 55px;border:1px solid #2b2b2b;box-shadow:0 25px 70px rgba(0,0,0,.45);overflow:hidden}
        .confirmacao-card:before{content:"";position:absolute;left:0;top:0;width:100%;height:5px;background:linear-gradient(90deg,#b7ff00,#00d9ff,#ff3cac)}
        .confirmacao-card:after{content:"SUA PACK";position:absolute;right:-10px;bottom:-25px;color:#171717;font-size:80px;font-weight:900;letter-spacing:-5px;line-height:1;pointer-events:none}
        .confirmacao-icone{position:relative;z-index:1;width:74px;height:74px;margin:0 auto 22px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:#b7ff00;color:#111;font-size:42px;font-weight:900;box-shadow:0 0 0 8px rgba(183,255,0,.08)}
        .confirmacao-marca{position:relative;z-index:1;color:#b7ff00;font-size:11px;font-weight:900;letter-spacing:3px;margin-bottom:12px}
        .confirmacao-card h1{position:relative;z-index:1;font-size:clamp(42px,7vw,78px);margin:0 0 15px;line-height:.88;letter-spacing:-3px}
        .numero-pedido{position:relative;z-index:1;font-size:16px;color:#d5d5d5;margin:22px 0 28px;line-height:1.6}.numero-pedido strong{color:#fff}
        .dados-pedido{position:relative;z-index:1;text-align:left;background:#f3f3f3;color:#111;padding:0;margin:25px 0;border:1px solid #ddd}
        .dados-pedido p{display:flex;justify-content:space-between;gap:20px;margin:0;padding:16px 20px;border-bottom:1px solid #ddd;font-size:14px}.dados-pedido p:last-child{border-bottom:0}.dados-pedido strong{font-weight:900}.dados-pedido p:last-child strong{color:#111}.dados-pedido p:last-child{font-weight:900}.dados-pedido p:last-child::after{content:""}
        .status-pedido{display:inline-flex;align-items:center;gap:7px;padding:5px 10px;background:#e8ffc2;color:#315000;font-size:11px;font-weight:900;text-transform:uppercase;letter-spacing:1px}
        .confirmacao-acoes{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:28px}
        .btn-voltar,.btn-produtos{display:flex;align-items:center;justify-content:center;min-height:54px;padding:15px 18px;box-sizing:border-box;text-decoration:none;font-weight:900;font-size:11px;letter-spacing:1px;text-transform:uppercase;transition:.2s}
        .btn-voltar{background:#f4f4f4;color:#111;border:1px solid #f4f4f4}.btn-voltar:hover{background:#b7ff00;border-color:#b7ff00}
        .btn-produtos{background:transparent;color:#fff;border:1px solid #444}.btn-produtos:hover{border-color:#00d9ff;color:#00d9ff}
        .confirmacao-observacao{position:relative;z-index:1;color:#8f8f8f;font-size:11px;margin:22px 0 0;line-height:1.6}
        @media(max-width:600px){.confirmacao{padding:35px 15px}.confirmacao-card{padding:48px 20px}.confirmacao-card h1{letter-spacing:-2px}.dados-pedido p{flex-direction:column;gap:5px}.confirmacao-acoes{grid-template-columns:1fr}.confirmacao-card:after{font-size:52px}}
    </style>

</head>


<body>


<main class="confirmacao">

    <section class="confirmacao-card">

        <div class="confirmacao-icone">✓</div>

        <div class="confirmacao-marca">SUA PACK / PEDIDO RECEBIDO</div>

        <h1>
            PEDIDO<br>
            CONFIRMADO!
        </h1>


        <p class="numero-pedido">

            Seu pedido foi registrado com sucesso. Obrigado por escolher a SUA PACK! 💗

        </p>


        <div class="dados-pedido">

            <p>

                <strong>
                    Pedido:
                </strong>

                #<?= $pedido["id_pedido"] ?>

            </p>


            <p>

                <strong>
                    Cliente:
                </strong>

                <?= htmlspecialchars(
                    $pedido["nome_cliente"]
                ) ?>

            </p>


            <p>

                <strong>
                    Pagamento:
                </strong>

                <?= htmlspecialchars(
                    $pedido["forma_pagamento"]
                ) ?>

            </p>


            <p>

                <strong>
                    Total:
                </strong>

                R$

                <?= number_format(
                    $pedido["valor_total"],
                    2,
                    ",",
                    "."
                ) ?>

            </p>


            <p>

                <strong>
                    Status:
                </strong>

                <span class="status-pedido">● <?= htmlspecialchars($pedido["status_pedido"]) ?></span>

            </p>

        </div>


        <div class="confirmacao-acoes">
            <a href="produtos.php" class="btn-produtos">← CONTINUAR COMPRANDO</a>
            <a href="index.php" class="btn-voltar">VOLTAR PARA A SUA PACK</a>
        </div>

        <p class="confirmacao-observacao">Guarde o número do pedido <strong>#<?= (int)$pedido["id_pedido"] ?></strong> para acompanhar sua compra.</p>

    </section>

</main>


</body>

</html>
