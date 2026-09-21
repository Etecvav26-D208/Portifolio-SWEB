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


$produto = mysqli_fetch_assoc(
    $resultado
);


/* =========================
   DEFINIR PREÇO
========================= */

$em_promocao =
    $produto["em_promocao"] == 1 &&
    !empty($produto["preco_promocional"]);


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

        /* =========================
           PÁGINA DO PRODUTO
        ========================= */

        .produto-detalhe {

            max-width: 1200px;

            margin: 0 auto;

            padding: 60px 25px 80px;

        }


        .voltar-produtos {

            display: inline-block;

            margin-bottom: 35px;

            color: #111;

            text-decoration: none;

            font-weight: bold;

            font-size: 15px;

        }


        .voltar-produtos:hover {

            text-decoration: underline;

        }


        .produto-container {

            display: grid;

            grid-template-columns:
                1fr
                1fr;

            gap: 60px;

            align-items: center;

        }


        /* =========================
           IMAGEM
        ========================= */

        .produto-imagem {

            width: 100%;

            min-height: 500px;

            background: #f5f5f5;

            display: flex;

            align-items: center;

            justify-content: center;

            overflow: hidden;

        }


        .produto-imagem img {

            width: 100%;

            height: 500px;

            object-fit: contain;

            display: block;

        }


        /* =========================
           INFORMAÇÕES
        ========================= */

        .produto-info {

            padding: 10px 0;

        }


        .produto-categoria {

            font-size: 13px;

            text-transform: uppercase;

            letter-spacing: 2px;

            color: #777;

            margin-bottom: 15px;

        }


        .produto-info h1 {

            font-size: clamp(35px, 5vw, 60px);

            line-height: 0.95;

            margin: 0 0 25px;

            text-transform: uppercase;

        }


        .produto-descricao {

            font-size: 17px;

            line-height: 1.7;

            color: #444;

            margin-bottom: 30px;

        }


        /* =========================
           PREÇO
        ========================= */

        .preco-antigo {

            color: #888;

            text-decoration: line-through;

            font-size: 17px;

            margin-bottom: 5px;

        }


        .preco-produto {

            font-size: 34px;

            font-weight: bold;

            margin-bottom: 25px;

        }


        .preco-promocional {

            color: #d6007f;

        }


        .tag-promocao {

            display: inline-block;

            background: #d6007f;

            color: white;

            padding: 7px 12px;

            font-size: 12px;

            font-weight: bold;

            margin-bottom: 15px;

        }


        /* =========================
           ESTOQUE
        ========================= */

        .estoque {

            font-size: 14px;

            margin-bottom: 25px;

            color: #555;

        }


        .sem-estoque {

            color: #d00000;

            font-weight: bold;

        }


        /* =========================
           QUANTIDADE
        ========================= */

        .quantidade-area {

            margin-bottom: 20px;

        }


        .quantidade-area label {

            display: block;

            font-weight: bold;

            margin-bottom: 8px;

        }


        .quantidade-area input {

            width: 100px;

            padding: 13px;

            border: 1px solid #ccc;

            font-size: 16px;

        }


        /* =========================
           BOTÃO
        ========================= */

        .btn-carrinho {

            width: 100%;

            padding: 18px;

            border: none;

            background: #111;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.2s;

        }


        .btn-carrinho:hover {

            background: #d6007f;

        }


        .btn-carrinho:disabled {

            background: #999;

            cursor: not-allowed;

        }


        /* =========================
           AVISO
        ========================= */

        .aviso-compra {

            margin-top: 20px;

            padding: 15px;

            background: #f5f5f5;

            font-size: 14px;

            line-height: 1.5;

        }


        /* =========================
           RESPONSIVO
        ========================= */

        @media (max-width: 800px) {

            .produto-container {

                grid-template-columns: 1fr;

                gap: 35px;

            }


            .produto-imagem {

                min-height: 350px;

            }


            .produto-imagem img {

                height: 350px;

            }

        }

    </style>

</head>


<body>


<main class="produto-detalhe">


    <!-- VOLTAR -->

    <a
        href="produtos.php"
        class="voltar-produtos"
    >

        ← VOLTAR PARA PRODUTOS

    </a>


    <div class="produto-container">


        <!-- =========================
             IMAGEM
        ========================== -->

        <div class="produto-imagem">

            <?php if (!empty($produto["imagem"])): ?>

                <img
                    src="img/<?= htmlspecialchars($produto["imagem"]) ?>"
                    alt="<?= htmlspecialchars($produto["nome"]) ?>"
                >

            <?php else: ?>

                <p>
                    Imagem não disponível
                </p>

            <?php endif; ?>

        </div>


        <!-- =========================
             INFORMAÇÕES
        ========================== -->

        <div class="produto-info">


            <?php if (!empty($produto["nome_categoria"])): ?>

                <div class="produto-categoria">

                    <?= htmlspecialchars($produto["nome_categoria"]) ?>

                </div>

            <?php endif; ?>


            <h1>

                <?= htmlspecialchars($produto["nome"]) ?>

            </h1>


            <?php if ($em_promocao): ?>

                <span class="tag-promocao">

                    PROMOÇÃO

                </span>

            <?php endif; ?>


            <!-- PREÇO -->

            <?php if ($em_promocao): ?>

                <div class="preco-antigo">

                    R$

                    <?= number_format(
                        $produto["preco"],
                        2,
                        ",",
                        "."
                    ) ?>

                </div>

            <?php endif; ?>


            <div
                class="
                    preco-produto
                    <?= $em_promocao ? 'preco-promocional' : '' ?>
                "
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


            <!-- =========================
                 FORMULÁRIO DO CARRINHO
            ========================== -->

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


            <div class="aviso-compra">

                💗 Depois de adicionar o produto,
                você poderá revisar seu pedido no carrinho
                antes de finalizar a compra.

            </div>


        </div>

    </div>

</main>


</body>

</html>
