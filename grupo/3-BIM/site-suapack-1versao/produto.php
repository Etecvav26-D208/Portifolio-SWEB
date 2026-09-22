
<?php

include("conexao.php");


/* =========================
   VERIFICAR ID DO PRODUTO
========================= */

if (
    !isset($_GET["id"]) ||
    !is_numeric($_GET["id"])
) {
    header("Location: produtos.php");
    exit;
}

$id_produto = intval($_GET["id"]);


/* =========================
   BUSCAR PRODUTO
========================= */

$sql = "
    SELECT 
        produtos.*,
        categorias.nome AS nome_categoria
    FROM produtos
    LEFT JOIN categorias
        ON produtos.id_categoria = categorias.id_categoria
    WHERE produtos.id_produto = $id_produto
";

$resultado = mysqli_query(
    $conexao,
    $sql
);


/* =========================
   VERIFICAR SE EXISTE
========================= */

if (
    !$resultado ||
    mysqli_num_rows($resultado) == 0
) {
    header("Location: produtos.php");
    exit;
}


$produto = mysqli_fetch_assoc($resultado);


/* =========================
   DEFINIR PREÇO
========================= */

$em_promocao =
    $produto["em_promocao"] == 1 &&
    !empty($produto["preco_promocional"]) &&
    $produto["preco_promocional"] > 0;


if ($em_promocao) {

    $preco = $produto["preco_promocional"];

} else {

    $preco = $produto["preco"];

}


/* =========================
   ESTOQUE
========================= */

$estoque = intval(
    $produto["estoque"]
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

    <title>
        <?= htmlspecialchars($produto["nome"]) ?> | SUA PACK
    </title>

    <link
        rel="stylesheet"
        href="style.css"
    >

    <style>

        /* ========================================
           PÁGINA DO PRODUTO
        ======================================== */

        .pagina-produto {

            min-height: 100vh;

            background-color: #efefe9;

            color: #000;

            padding: 60px 6% 100px;

        }


        .produto-detalhe {

            max-width: 1200px;

            margin: 0 auto;

        }


        /* VOLTAR */

        .voltar-produtos {

            display: inline-block;

            margin-bottom: 40px;

            color: #000;

            font-size: 13px;

            font-weight: bold;

            text-transform: uppercase;

        }


        .voltar-produtos:hover {

            color: #d6007f;

        }


        /* CONTAINER */

        .produto-container {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 60px;

            align-items: center;

        }


        /* ========================================
           IMAGEM
        ======================================== */

        .produto-detalhe-imagem {

            width: 100%;

            min-height: 550px;

            background-color: #fff;

            display: flex;

            align-items: center;

            justify-content: center;

            overflow: hidden;

        }


        .produto-detalhe-imagem img {

            width: 100%;

            height: 550px;

            object-fit: contain;

            display: block;

        }


        .imagem-indisponivel {

            color: #777;

            font-size: 14px;

        }


        /* ========================================
           INFORMAÇÕES
        ======================================== */

        .produto-detalhe-info {

            padding: 10px 0;

        }


        .produto-detalhe-categoria {

            color: #777;

            font-size: 11px;

            font-weight: bold;

            letter-spacing: 3px;

            text-transform: uppercase;

            margin-bottom: 15px;

        }


        .produto-detalhe-info h1 {

            font-family: Impact, "Arial Black", sans-serif;

            font-size: clamp(45px, 6vw, 80px);

            line-height: 0.9;

            text-transform: uppercase;

            margin-bottom: 25px;

        }


        /* ========================================
           PROMOÇÃO
        ======================================== */

        .tag-promocao {

            display: inline-block;

            margin-bottom: 15px;

            padding: 8px 12px;

            background-color: #d6007f;

            color: #fff;

            font-size: 11px;

            font-weight: bold;

        }


        .preco-antigo-produto {

            color: #888;

            font-size: 16px;

            text-decoration: line-through;

            margin-bottom: 5px;

        }


        .preco-produto {

            color: #000;

            font-size: 35px;

            font-weight: bold;

            margin-bottom: 25px;

        }


        .preco-produto.promocional {

            color: #d6007f;

        }


        /* ========================================
           DESCRIÇÃO
        ======================================== */

        .produto-descricao {

            max-width: 600px;

            color: #444;

            font-size: 15px;

            line-height: 1.8;

            margin-bottom: 25px;

        }


        /* ========================================
           ESTOQUE
        ======================================== */

        .estoque {

            margin-bottom: 25px;

            color: #555;

            font-size: 14px;

        }


        .estoque strong {

            color: #000;

        }


        .sem-estoque {

            color: #d00000;

            font-weight: bold;

        }


        /* ========================================
           QUANTIDADE
        ======================================== */

        .quantidade-area {

            margin-bottom: 20px;

        }


        .quantidade-area label {

            display: block;

            margin-bottom: 8px;

            font-size: 13px;

            font-weight: bold;

        }


        .quantidade-area input {

            width: 100px;

            padding: 12px;

            border: 1px solid #ccc;

            background-color: #fff;

            font-size: 16px;

        }


        /* ========================================
           BOTÃO CARRINHO
        ======================================== */

        .btn-carrinho {

            width: 100%;

            padding: 18px;

            border: none;

            background-color: #000;

            color: #fff;

            font-size: 14px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.3s;

        }


        .btn-carrinho:hover {

            background-color: #d6007f;

        }


        .btn-carrinho:disabled {

            background-color: #999;

            cursor: not-allowed;

        }


        /* ========================================
           AVISO
        ======================================== */

        .aviso-compra {

            margin-top: 20px;

            padding: 15px;

            background-color: #fff;

            color: #555;

            font-size: 13px;

            line-height: 1.6;

        }


        /* ========================================
           RESPONSIVO
        ======================================== */

        @media (max-width: 800px) {

            .pagina-produto {

                padding: 40px 20px 70px;

            }


            .produto-container {

                grid-template-columns: 1fr;

                gap: 35px;

            }


            .produto-detalhe-imagem {

                min-height: 400px;

            }


            .produto-detalhe-imagem img {

                height: 400px;

            }


            .produto-detalhe-info h1 {

                font-size: 55px;

            }

        }


        @media (max-width: 500px) {

            .produto-detalhe-imagem {

                min-height: 320px;

            }


            .produto-detalhe-imagem img {

                height: 320px;

            }


            .produto-detalhe-info h1 {

                font-size: 45px;

            }


            .preco-produto {

                font-size: 30px;

            }

        }

    </style>

</head>


<body>


<main class="pagina-produto">

    <div class="produto-detalhe">


        <!-- VOLTAR -->

        <a
            href="produtos.php"
            class="voltar-produtos"
        >
            ← VOLTAR PARA PRODUTOS
        </a>


        <div class="produto-container">


            <!-- ========================================
                 IMAGEM DO PRODUTO
            ======================================== -->

            <div class="produto-detalhe-imagem">

                <?php if (!empty($produto["imagem"])): ?>

                    <img
                        src="img/<?= htmlspecialchars($produto["imagem"]) ?>"
                        alt="<?= htmlspecialchars($produto["nome"]) ?>"
                    >

                <?php else: ?>

                    <p class="imagem-indisponivel">
                        Imagem não disponível
                    </p>

                <?php endif; ?>

            </div>


            <!-- ========================================
                 INFORMAÇÕES
            ======================================== -->

            <div class="produto-detalhe-info">


                <!-- CATEGORIA -->

                <?php if (!empty($produto["nome_categoria"])): ?>

                    <div class="produto-detalhe-categoria">

                        <?= htmlspecialchars(
                            $produto["nome_categoria"]
                        ) ?>

                    </div>

                <?php endif; ?>


                <!-- NOME -->

                <h1>

                    <?= htmlspecialchars(
                        $produto["nome"]
                    ) ?>

                </h1>


                <!-- PROMOÇÃO -->

                <?php if ($em_promocao): ?>

                    <span class="tag-promocao">

                        PROMOÇÃO

                    </span>

                <?php endif; ?>


                <!-- PREÇO ANTIGO -->

                <?php if ($em_promocao): ?>

                    <div class="preco-antigo-produto">

                        R$

                        <?= number_format(
                            $produto["preco"],
                            2,
                            ",",
                            "."
                        ) ?>

                    </div>

                <?php endif; ?>


                <!-- PREÇO ATUAL -->

                <div
                    class="preco-produto <?= $em_promocao ? 'promocional' : '' ?>"
                >

                    R$

                    <?= number_format(
                        $preco,
                        2,
                        ",",
                        "."
                    ) ?>

                </div>


                <!-- DESCRIÇÃO -->

                <?php if (!empty($produto["descricao"])): ?>

                    <div class="produto-descricao">

                        <?= nl2br(
                            htmlspecialchars(
                                $produto["descricao"]
                            )
                        ) ?>

                    </div>

                <?php endif; ?>


                <!-- ESTOQUE -->

                <?php if ($estoque > 0): ?>

                    <div class="estoque">

                        Disponível em estoque:

                        <strong>
                            <?= $estoque ?>
                        </strong>

                    </div>

                <?php else: ?>

                    <div class="estoque sem-estoque">

                        Produto sem estoque.

                    </div>

                <?php endif; ?>


                <!-- ========================================
                     FORMULÁRIO
                ======================================== -->

                <form
                    action="carrinho.php"
                    method="POST"
                >

                    <input
                        type="hidden"
                        name="id_produto"
                        value="<?= $produto["id_produto"] ?>"
                    >


                    <?php if ($estoque > 0): ?>

                        <!-- QUANTIDADE -->

                        <div class="quantidade-area">

                            <label for="quantidade">

                                Quantidade:

                            </label>

                            <input
                                type="number"
                                id="quantidade"
                                name="quantidade"
                                value="1"
                                min="1"
                                max="<?= $estoque ?>"
                                required
                            >

                        </div>


                        <!-- BOTÃO -->

                        <button
                            type="submit"
                            name="adicionar"
                            class="btn-carrinho"
                        >

                            🛒 ADICIONAR AO CARRINHO

                        </button>


                    <?php else: ?>

                        <button
                            type="button"
                            class="btn-carrinho"
                            disabled
                        >

                            PRODUTO ESGOTADO

                        </button>

                    <?php endif; ?>

                </form>


                <!-- AVISO -->

                <div class="aviso-compra">

                    💗 Depois de adicionar o produto,
                    você poderá revisar seu pedido no carrinho
                    antes de finalizar a compra.

                </div>


            </div>

        </div>

    </div>

</main>


</body>

</html>
