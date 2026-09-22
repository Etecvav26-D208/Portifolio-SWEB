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

        .carrinho-pagina {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 5%;
        }

        .carrinho-topo {
            margin-bottom: 40px;
        }

        .carrinho-topo a {
            color: #111;
            text-decoration: none;
            font-weight: bold;
        }

        .carrinho-topo h1 {
            font-size: clamp(40px, 6vw, 70px);
            margin: 25px 0 10px;
            line-height: 0.95;
        }

        .carrinho-conteudo {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 40px;
            align-items: start;
        }

        .carrinho-produtos {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .item-carrinho {
            display: grid;
            grid-template-columns: 130px 1fr auto;
            gap: 20px;
            align-items: center;
            background: #f4f4f4;
            padding: 20px;
        }

        .item-imagem {
            width: 130px;
            height: 130px;
            background: #e9e9e9;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .item-imagem img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .item-sem-imagem {
            font-size: 45px;
        }

        .item-info h2 {
            margin: 5px 0;
            font-size: 22px;
        }

        .item-info p {
            margin: 5px 0;
        }

        .item-preco {
            font-weight: bold;
            font-size: 18px;
        }

        .item-quantidade {
            margin-top: 15px;
        }

        .item-quantidade input {
            width: 65px;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .remover {
            display: inline-block;
            margin-top: 10px;
            color: #c00;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
        }

        .item-subtotal {
            text-align: right;
            font-weight: bold;
            font-size: 18px;
        }

        .resumo-carrinho {
            background: #111;
            color: white;
            padding: 30px;
            position: sticky;
            top: 20px;
        }

        .resumo-carrinho h2 {
            margin-top: 0;
        }

        .resumo-linha {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
        }

        .resumo-total {
            border-top: 1px solid #555;
            padding-top: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .btn-checkout {
            display: block;
            width: 100%;
            padding: 16px;
            margin-top: 25px;
            background: white;
            color: #111;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            border: none;
            cursor: pointer;
            box-sizing: border-box;
        }

        .btn-atualizar {
            display: inline-block;
            margin-top: 20px;
            padding: 13px 20px;
            background: #111;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .carrinho-vazio {
            text-align: center;
            padding: 80px 20px;
            background: #f4f4f4;
        }

        .carrinho-vazio h2 {
            font-size: 32px;
        }

        .btn-continuar {
            display: inline-block;
            margin-top: 15px;
            padding: 15px 25px;
            background: #111;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        @media (max-width: 800px) {

            .carrinho-conteudo {
                grid-template-columns: 1fr;
            }

            .resumo-carrinho {
                position: static;
            }

            .item-carrinho {
                grid-template-columns: 90px 1fr;
            }

            .item-imagem {
                width: 90px;
                height: 90px;
            }

            .item-subtotal {
                grid-column: 2;
                text-align: left;
            }
        }

        @media (max-width: 500px) {

            .carrinho-pagina {
                padding: 40px 20px;
            }

            .item-carrinho {
                gap: 12px;
                padding: 15px;
            }

            .item-info h2 {
                font-size: 18px;
            }
        }

    </style>

</head>

<body>

<main class="carrinho-pagina">

    <div class="carrinho-topo">

        <a href="produtos.php">← Continuar comprando</a>

        <h1>SEU CARRINHO</h1>

        <p>
            Confira seus produtos antes de finalizar a compra.
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
                        ATUALIZAR CARRINHO
                    </button>

                </form>

            </section>


            <!-- RESUMO -->

            <aside class="resumo-carrinho">

                <h2>RESUMO DO PEDIDO</h2>

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
