<?php
session_start();

include("conexao.php");

/* Criar o carrinho caso ainda não exista */
if (!isset($_SESSION["carrinho"])) {
    $_SESSION["carrinho"] = [];
}

/* ADICIONAR PRODUTO */
if (isset($_POST["adicionar"])) {

    $id_produto = intval($_POST["id_produto"]);
    $quantidade = intval($_POST["quantidade"]);

    if ($quantidade < 1) {
        $quantidade = 1;
    }

    /* Verificar se o produto existe */
    $sql = "
        SELECT *
        FROM produtos
        WHERE id_produto = $id_produto
    ";

    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {

        $produto = mysqli_fetch_assoc($resultado);

        /* Verificar estoque */
        if ($produto["estoque"] > 0) {

            if (isset($_SESSION["carrinho"][$id_produto])) {

                $_SESSION["carrinho"][$id_produto] += $quantidade;

            } else {

                $_SESSION["carrinho"][$id_produto] = $quantidade;
            }

            /* Não deixar passar do estoque */
            if ($_SESSION["carrinho"][$id_produto] > $produto["estoque"]) {
                $_SESSION["carrinho"][$id_produto] = $produto["estoque"];
            }
        }
    }

    header("Location: carrinho.php");
    exit;
}


/* ATUALIZAR QUANTIDADES */
if (isset($_POST["atualizar"])) {

    if (isset($_POST["quantidade"]) && is_array($_POST["quantidade"])) {

        foreach ($_POST["quantidade"] as $id_produto => $quantidade) {

            $id_produto = intval($id_produto);
            $quantidade = intval($quantidade);

            if ($quantidade <= 0) {

                unset($_SESSION["carrinho"][$id_produto]);

            } else {

                /* Buscar estoque atual */
                $sql = "
                    SELECT estoque
                    FROM produtos
                    WHERE id_produto = $id_produto
                ";

                $resultado = mysqli_query($conexao, $sql);

                if ($resultado && mysqli_num_rows($resultado) > 0) {

                    $produto = mysqli_fetch_assoc($resultado);

                    if ($quantidade > $produto["estoque"]) {
                        $quantidade = $produto["estoque"];
                    }

                    if ($quantidade > 0) {
                        $_SESSION["carrinho"][$id_produto] = $quantidade;
                    } else {
                        unset($_SESSION["carrinho"][$id_produto]);
                    }
                }
            }
        }
    }

    header("Location: carrinho.php");
    exit;
}


/* REMOVER PRODUTO */
if (isset($_GET["remover"])) {

    $id_produto = intval($_GET["remover"]);

    unset($_SESSION["carrinho"][$id_produto]);

    header("Location: carrinho.php");
    exit;
}


/* BUSCAR PRODUTOS DO CARRINHO */
$produtos_carrinho = [];
$total = 0;

if (!empty($_SESSION["carrinho"])) {

    foreach ($_SESSION["carrinho"] as $id_produto => $quantidade) {

        $id_produto = intval($id_produto);

        $sql = "
            SELECT *
            FROM produtos
            WHERE id_produto = $id_produto
        ";

        $resultado = mysqli_query($conexao, $sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {

            $produto = mysqli_fetch_assoc($resultado);

            /* Definir preço */
            if (
                $produto["em_promocao"] == 1 &&
                !empty($produto["preco_promocional"]) &&
                $produto["preco_promocional"] > 0
            ) {
                $preco = $produto["preco_promocional"];
            } else {
                $preco = $produto["preco"];
            }

            $subtotal = $preco * $quantidade;

            $produto["quantidade"] = $quantidade;
            $produto["preco_calculado"] = $preco;
            $produto["subtotal"] = $subtotal;

            $produtos_carrinho[] = $produto;

            $total += $subtotal;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Carrinho | SUA PACK</title>

    <link rel="stylesheet" href="style.css">

    <style>
        .carrinho-pagina{max-width:1240px;margin:0 auto;padding:70px 5% 100px}
        .carrinho-topo{margin-bottom:42px}
        .carrinho-topo a{display:inline-flex;align-items:center;gap:8px;color:#bdbdbd;text-decoration:none;font-size:13px;font-weight:800;letter-spacing:1px;text-transform:uppercase;transition:.2s}
        .carrinho-topo a:hover{color:#b7ff00;transform:translateX(-3px)}
        .carrinho-topo h1{font-size:clamp(48px,7vw,88px);margin:26px 0 12px;line-height:.88;letter-spacing:-3px}
        .carrinho-topo p{margin:0;color:#cfcfcf;max-width:620px;line-height:1.6;font-size:15px}
        .carrinho-topo .marca-carrinho{display:block;color:#b7ff00;font-size:12px;font-weight:900;letter-spacing:4px;margin-bottom:8px}
        .carrinho-conteudo{display:grid;grid-template-columns:minmax(0,1fr) 370px;gap:30px;align-items:start}
        .carrinho-produtos{display:flex;flex-direction:column;gap:14px}
        .item-carrinho{position:relative;display:grid;grid-template-columns:148px minmax(0,1fr) auto;gap:22px;align-items:center;background:linear-gradient(135deg,#f8f8f8 0%,#ededed 100%);padding:18px;border:1px solid #2b2b2b;box-shadow:0 12px 30px rgba(0,0,0,.18);overflow:hidden}
        .item-carrinho:before{content:"";position:absolute;left:0;top:0;bottom:0;width:4px;background:linear-gradient(180deg,#b7ff00,#00d9ff,#ff3cac)}
        .item-imagem{width:148px;height:148px;background:#e1e1e1;display:flex;align-items:center;justify-content:center;overflow:hidden}
        .item-imagem img{width:100%;height:100%;object-fit:cover;transition:transform .3s ease}.item-carrinho:hover .item-imagem img{transform:scale(1.04)}
        .item-sem-imagem{font-size:45px}
        .item-info h2{margin:5px 0 8px;font-size:24px;line-height:1.05;letter-spacing:-.5px;color:#111}
        .item-info p{margin:5px 0;color:#555;font-size:13px}.item-info .item-preco{color:#111;font-size:19px;font-weight:900}
        .item-quantidade{margin-top:16px;display:flex;align-items:center;gap:10px}.item-quantidade label{font-size:11px;font-weight:900;letter-spacing:1.5px;text-transform:uppercase;color:#666}
        .item-quantidade input{width:72px;height:42px;padding:0 10px;border:1px solid #bbb;background:#fff;color:#111;font-size:15px;font-weight:700;outline:none;box-sizing:border-box}.item-quantidade input:focus{border-color:#111;box-shadow:0 0 0 2px #b7ff00}
        .remover{display:inline-flex;margin-top:12px;color:#c81d4b;text-decoration:none;font-size:11px;font-weight:900;letter-spacing:1.2px;text-transform:uppercase}.remover:hover{color:#ff3cac;text-decoration:underline}
        .item-subtotal{text-align:right;font-weight:900;font-size:20px;color:#111;white-space:nowrap;align-self:end;padding-bottom:5px}.item-subtotal small{display:block;color:#777;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:5px}
        .acoes-carrinho{display:flex;justify-content:space-between;align-items:center;gap:15px;margin-top:18px;flex-wrap:wrap}
        .btn-atualizar,.btn-continuar{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:14px 20px;min-height:48px;box-sizing:border-box;text-decoration:none;font-size:11px;font-weight:900;letter-spacing:1.2px;text-transform:uppercase;cursor:pointer;transition:.2s}
        .btn-atualizar{background:#151515;color:#fff;border:1px solid #2b2b2b}.btn-atualizar:hover{background:#b7ff00;color:#111;border-color:#b7ff00}
        .btn-continuar{background:transparent;color:#fff;border:1px solid #444}.btn-continuar:hover{border-color:#b7ff00;color:#b7ff00}
        .resumo-carrinho{background:linear-gradient(145deg,#151515,#0d0d0d);color:white;padding:30px;position:sticky;top:24px;border:1px solid #282828;box-shadow:0 18px 45px rgba(0,0,0,.35);overflow:hidden}
        .resumo-carrinho:before{content:"";display:block;height:4px;margin:-30px -30px 26px;background:linear-gradient(90deg,#b7ff00,#00d9ff,#ff3cac)}
        .resumo-carrinho h2{margin:0 0 25px;font-size:22px;letter-spacing:-.3px}.resumo-carrinho h2 span{display:block;color:#b7ff00;font-size:10px;letter-spacing:2.5px;margin-bottom:7px}
        .resumo-linha{display:flex;justify-content:space-between;gap:20px;margin:15px 0;color:#cfcfcf;font-size:14px}.resumo-linha strong{color:#fff}
        .resumo-total{border-top:1px solid #333;padding-top:20px;margin-top:22px;font-size:26px;font-weight:900;color:#fff}.resumo-total span:last-child{color:#b7ff00}
        .btn-checkout{display:flex;align-items:center;justify-content:center;width:100%;min-height:56px;padding:16px;margin-top:25px;background:#f5f5f5;color:#111;text-align:center;text-decoration:none;font-weight:900;letter-spacing:.5px;border:none;cursor:pointer;box-sizing:border-box;transition:.2s}.btn-checkout:hover{background:#b7ff00;transform:translateY(-2px)}
        .carrinho-vazio{text-align:center;padding:90px 25px;background:linear-gradient(145deg,#151515,#0e0e0e);border:1px solid #292929}.carrinho-vazio .vazio-icone{font-size:48px;margin-bottom:10px}.carrinho-vazio h2{font-size:34px;margin:0 0 10px;color:#fff}.carrinho-vazio p{color:#aaa;margin:0}.carrinho-vazio .btn-continuar{margin-top:25px;background:#b7ff00;color:#111;border-color:#b7ff00}
        @media(max-width:900px){.carrinho-conteudo{grid-template-columns:1fr}.resumo-carrinho{position:static}.item-carrinho{grid-template-columns:110px minmax(0,1fr);}.item-imagem{width:110px;height:110px}.item-subtotal{grid-column:2;text-align:left}.acoes-carrinho{align-items:stretch}.acoes-carrinho>*{flex:1}}
        @media(max-width:600px){.carrinho-pagina{padding:45px 20px 70px}.carrinho-topo h1{letter-spacing:-2px}.item-carrinho{grid-template-columns:1fr;padding:15px}.item-imagem{width:100%;height:220px}.item-subtotal{grid-column:auto}.acoes-carrinho{flex-direction:column}.acoes-carrinho>*{width:100%;flex:none}.resumo-carrinho{padding:24px}.resumo-carrinho:before{margin:-24px -24px 22px}}
    </style>

</head>

<body>

<main class="carrinho-pagina">

    <div class="carrinho-topo">

        <span class="marca-carrinho">SUA PACK / BAG SYSTEM</span>

        <a href="produtos.php">← Continuar comprando</a>

        <h1>SEU CARRINHO</h1>

        <p>
            Revise sua seleção, ajuste as quantidades e continue montando sua vibe antes de finalizar.
        </p>

    </div>


    <?php if (empty($produtos_carrinho)) { ?>

        <section class="carrinho-vazio">

            <h2>Seu carrinho está vazio 🛍️</h2>

            <p>
                Ainda não tem nenhum produto aqui.
            </p>

            <a href="produtos.php" class="btn-continuar">
                VER PRODUTOS
            </a>

        </section>

    <?php } else { ?>


        <div class="carrinho-conteudo">


            <!-- PRODUTOS -->

            <section class="carrinho-produtos">

                <form method="POST">

                    <?php foreach ($produtos_carrinho as $produto) { ?>

                        <article class="item-carrinho">

                            <div class="item-imagem">

                                <?php if (!empty($produto["imagem"])) { ?>

                                    <img
                                        src="img/<?= htmlspecialchars($produto["imagem"]) ?>"
                                        alt="<?= htmlspecialchars($produto["nome"]) ?>"
                                    >

                                <?php } else { ?>

                                    <div class="item-sem-imagem">
                                        🛍️
                                    </div>

                                <?php } ?>

                            </div>


                            <div class="item-info">

                                <small>
                                    SUA PACK
                                </small>

                                <h2>
                                    <?= htmlspecialchars($produto["nome"]) ?>
                                </h2>

                                <p class="item-preco">
                                    R$ <?= number_format(
                                        $produto["preco_calculado"],
                                        2,
                                        ",",
                                        "."
                                    ) ?>
                                </p>

                                <div class="item-quantidade">

                                    <label>
                                        Quantidade:
                                    </label>

                                    <input
                                        type="number"
                                        name="quantidade[<?= $produto["id_produto"] ?>]"
                                        value="<?= $produto["quantidade"] ?>"
                                        min="1"
                                        max="<?= $produto["estoque"] ?>"
                                    >

                                </div>

                                <a
                                    href="carrinho.php?remover=<?= $produto["id_produto"] ?>"
                                    class="remover"
                                >
                                    REMOVER
                                </a>

                            </div>


                            <div class="item-subtotal">
                                <small>Subtotal</small>
                                R$ <?= number_format(
                                    $produto["subtotal"],
                                    2,
                                    ",",
                                    "."
                                ) ?>

                            </div>

                        </article>

                    <?php } ?>


                    <button
                        type="submit"
                        name="atualizar"
                        class="btn-atualizar"
                    >
                        ATUALIZAR CARRINHO ↻
                    </button>

                </form>

                <div class="acoes-carrinho">
                    <a href="produtos.php" class="btn-continuar">← CONTINUAR COMPRANDO</a>
                </div>

            </section>


            <!-- RESUMO -->

            <aside class="resumo-carrinho">

                <h2><span>CHECKOUT / SUA PACK</span>RESUMO DO PEDIDO</h2>

                <div class="resumo-linha">

                    <span>Subtotal</span>

                    <span>
                        R$ <?= number_format(
                            $total,
                            2,
                            ",",
                            "."
                        ) ?>
                    </span>

                </div>


                <div class="resumo-linha">

                    <span>Frete</span>

                    <span>
                        Calculado no checkout
                    </span>

                </div>


                <div class="resumo-linha resumo-total">

                    <span>Total</span>

                    <span>
                        R$ <?= number_format(
                            $total,
                            2,
                            ",",
                            "."
                        ) ?>
                    </span>

                </div>


                <a
                    href="checkout.php"
                    class="btn-checkout"
                >
                    IR PARA O CHECKOUT →
                </a>

            </aside>

        </div>

    <?php } ?>

</main>

</body>

</html>
