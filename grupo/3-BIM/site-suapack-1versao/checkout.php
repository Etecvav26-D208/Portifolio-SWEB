<?php
session_start();

include("conexao.php");

if (!isset($_SESSION["carrinho"]) || empty($_SESSION["carrinho"])) {
    header("Location: carrinho.php");
    exit;
}

$produtos_carrinho = [];
$total = 0;

foreach ($_SESSION["carrinho"] as $id_produto => $quantidade) {

    $id_produto = intval($id_produto);
    $quantidade = intval($quantidade);

    $sql = "
        SELECT *
        FROM produtos
        WHERE id_produto = $id_produto
    ";

    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {

        $produto = mysqli_fetch_assoc($resultado);

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
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checkout | SUA PACK</title>

    <link rel="stylesheet" href="style.css">

    <style>

        .checkout-pagina {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 5%;
        }

        .checkout-topo {
            margin-bottom: 40px;
        }

        .checkout-topo a {
            color: #111;
            text-decoration: none;
            font-weight: bold;
        }

        .checkout-topo h1 {
            font-size: clamp(40px, 6vw, 70px);
            margin: 25px 0 10px;
            line-height: 0.95;
        }

        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 40px;
            align-items: start;
        }

        .checkout-formulario {
            background: #f4f4f4;
            padding: 30px;
        }

        .checkout-formulario h2 {
            margin-top: 0;
            margin-bottom: 25px;
        }

        .campo {
            margin-bottom: 18px;
        }

        .campo label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        .campo input,
        .campo select {
            width: 100%;
            padding: 13px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-family: inherit;
        }

        .linha-campos {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .pagamento {
            margin-top: 30px;
            border-top: 1px solid #ccc;
            padding-top: 25px;
        }

        .resumo-checkout {
            background: #111;
            color: white;
            padding: 30px;
            position: sticky;
            top: 20px;
        }

        .resumo-checkout h2 {
            margin-top: 0;
        }

        .produto-resumo {
            padding: 12px 0;
            border-bottom: 1px solid #444;
        }

        .produto-resumo-linha {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .total-checkout {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #555;
            font-size: 23px;
            font-weight: bold;
        }

        .btn-finalizar {
            width: 100%;
            padding: 17px;
            margin-top: 25px;
            border: none;
            background: white;
            color: #111;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
        }

        @media (max-width: 800px) {

            .checkout-layout {
                grid-template-columns: 1fr;
            }

            .resumo-checkout {
                position: static;
            }

        }

        @media (max-width: 500px) {

            .checkout-pagina {
                padding: 40px 20px;
            }

            .linha-campos {
                grid-template-columns: 1fr;
            }

            .checkout-formulario,
            .resumo-checkout {
                padding: 20px;
            }

        }

    </style>

</head>

<body>

<main class="checkout-pagina">

    <div class="checkout-topo">

        <a href="carrinho.php">← Voltar para o carrinho</a>

        <h1>CHECKOUT</h1>

        <p>
            Preencha seus dados para finalizar o pedido.
        </p>

    </div>


    <div class="checkout-layout">


        <!-- FORMULÁRIO -->

        <section class="checkout-formulario">

            <form action="finalizar_pedido.php" method="POST">

                <h2>📍 ENDEREÇO DE ENTREGA</h2>


                <div class="campo">

                    <label for="nome">
                        Nome completo
                    </label>

                    <input
                        type="text"
                        id="nome"
                        name="nome_cliente"
                        required
                    >

                </div>


                <div class="campo">

                    <label for="endereco">
                        Endereço completo
                    </label>

                    <input
                        type="text"
                        id="endereco"
                        name="endereco"
                        placeholder="Rua, número, bairro, cidade - UF"
                        required
                    >

                </div>


                <div class="linha-campos">

                    <div class="campo">

                        <label for="cep">
                            CEP
                        </label>

                        <input
                            type="text"
                            id="cep"
                            name="cep"
                            placeholder="00000-000"
                            required
                        >

                    </div>


                    <div class="campo">

                        <label for="complemento">
                            Complemento
                        </label>

                        <input
                            type="text"
                            id="complemento"
                            name="complemento"
                            placeholder="Apartamento, casa..."
                        >

                    </div>

                </div>


                <div class="pagamento">

                    <h2>💳 FORMA DE PAGAMENTO</h2>

                    <div class="campo">

                        <label for="pagamento">
                            Escolha uma opção
                        </label>

                        <select
                            id="pagamento"
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

                    </div>

                </div>


                <button
                    type="submit"
                    class="btn-finalizar"
                >
                    FINALIZAR PEDIDO →
                </button>

            </form>

        </section>


        <!-- RESUMO -->

        <aside class="resumo-checkout">

            <h2>SEU PEDIDO</h2>


            <?php foreach ($produtos_carrinho as $produto) { ?>

                <div class="produto-resumo">

                    <div class="produto-resumo-linha">

                        <span>
                            <?= htmlspecialchars($produto["nome"]) ?>
                            x<?= $produto["quantidade"] ?>
                        </span>

                        <span>
                            R$ <?= number_format(
                                $produto["subtotal"],
                                2,
                                ",",
                                "."
                            ) ?>
                        </span>

                    </div>

                </div>

            <?php } ?>


            <div class="total-checkout">

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

        </aside>

    </div>

</main>

</body>

</html>
