<?php

include("conexao.php");


if (
    !isset($_GET["id"]) ||
    !is_numeric($_GET["id"])
) {

    header("Location: index.php");

    exit;
}


$id_pedido = intval($_GET["id"]);


$sql = "
    SELECT *
    FROM pedidos
    WHERE id_pedido = $id_pedido
";


$resultado = mysqli_query(
    $conexao,
    $sql
);


if (
    !$resultado ||
    mysqli_num_rows($resultado) == 0
) {

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

        .confirmacao {

            min-height: 80vh;

            display: flex;

            justify-content: center;

            align-items: center;

            padding: 40px 20px;

        }


        .confirmacao-card {

            max-width: 650px;

            width: 100%;

            text-align: center;

            background: #f4f4f4;

            padding: 60px 30px;

        }


        .confirmacao-icone {

            font-size: 65px;

            margin-bottom: 20px;

        }


        .confirmacao-card h1 {

            font-size: clamp(38px, 6vw, 65px);

            margin: 0 0 15px;

            line-height: 0.95;

        }


        .numero-pedido {

            font-size: 18px;

            margin: 25px 0;

        }


        .dados-pedido {

            text-align: left;

            background: white;

            padding: 20px;

            margin: 25px 0;

        }


        .dados-pedido p {

            margin: 10px 0;

        }


        .btn-voltar {

            display: inline-block;

            padding: 16px 25px;

            background: #111;

            color: white;

            text-decoration: none;

            font-weight: bold;

        }

    </style>

</head>


<body>


<main class="confirmacao">

    <section class="confirmacao-card">

        <div class="confirmacao-icone">
            ✓
        </div>


        <h1>
            PEDIDO<br>
            CONFIRMADO!
        </h1>


        <p class="numero-pedido">

            Obrigado por comprar na SUA PACK! 💗

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

                <?= htmlspecialchars(
                    $pedido["status_pedido"]
                ) ?>

            </p>

        </div>


        <a
            href="index.php"
            class="btn-voltar"
        >
            VOLTAR PARA A SUA PACK
        </a>

    </section>

</main>


</body>

</html>
