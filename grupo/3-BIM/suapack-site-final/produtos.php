<?php
require_once "includes/auth.php";
bloquear_admin_na_loja("admin/index.php");
include("conexao.php");

/*
|--------------------------------------------------------------------------
| PESQUISA
|--------------------------------------------------------------------------
*/

$busca = "";

if (isset($_GET["busca"])) {
    $busca = trim($_GET["busca"]);
}

/*
|--------------------------------------------------------------------------
| BUSCAR CATEGORIAS
|--------------------------------------------------------------------------
*/

$sql_categorias = "
    SELECT *
    FROM categorias
    ORDER BY id_categoria ASC
";

$resultado_categorias = mysqli_query($conexao, $sql_categorias);


/*
|--------------------------------------------------------------------------
| VERIFICAR SE EXISTEM RESULTADOS
|--------------------------------------------------------------------------
*/

$tem_resultados = false;

if ($busca != "") {

    $busca_segura = mysqli_real_escape_string($conexao, $busca);

    $sql_resultados = "
        SELECT 
            produtos.id_produto,
            produtos.nome,
            produtos.descricao,
            produtos.preco,
            produtos.preco_promocional,
            produtos.imagem,
            produtos.estoque,
            produtos.em_promocao,
            categorias.nome AS categoria
        FROM produtos
        LEFT JOIN categorias
            ON produtos.id_categoria = categorias.id_categoria
        WHERE 
            produtos.nome LIKE '%$busca_segura%'
            OR produtos.descricao LIKE '%$busca_segura%'
            OR categorias.nome LIKE '%$busca_segura%'
        ORDER BY produtos.id_produto DESC
    ";

    $resultado_busca = mysqli_query($conexao, $sql_resultados);

    if ($resultado_busca && mysqli_num_rows($resultado_busca) > 0) {
        $tem_resultados = true;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Produtos | SUA PACK</title>

    <link rel="stylesheet" href="style.css">

    <style>

        /*
        |--------------------------------------------------------------------------
        | PÁGINA DE PRODUTOS
        |--------------------------------------------------------------------------
        */

        .produtos-pagina {
            max-width: 1400px;
            margin: 0 auto;
            padding: 70px 5%;
        }

        .titulo-produtos {
            margin-bottom: 40px;
        }

        .titulo-produtos span {
            font-size: 14px;
            letter-spacing: 3px;
            font-weight: bold;
        }

        .titulo-produtos h1 {
            font-size: clamp(40px, 6vw, 75px);
            margin: 10px 0;
            line-height: 0.95;
        }

        .titulo-produtos p {
            max-width: 600px;
            line-height: 1.6;
        }


        /*
        |--------------------------------------------------------------------------
        | PESQUISA
        |--------------------------------------------------------------------------
        */

        .area-pesquisa {
            position: relative;
            margin-bottom: 65px;
            padding: 28px;
            background: linear-gradient(135deg,#f7f7f7 0%,#ececec 100%);
            border: 1px solid #2d2d2d;
            box-shadow: 0 18px 45px rgba(0,0,0,.2);
            overflow: hidden;
        }

        .area-pesquisa:before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 5px;
            height: 100%;
            background: linear-gradient(180deg,#b7ff00,#00d9ff,#ff3cac);
        }

        .area-pesquisa:after {
            content: "SUA PACK";
            position: absolute;
            right: 25px;
            bottom: -12px;
            color: #dcdcdc;
            font-size: 52px;
            line-height: 1;
            font-weight: 900;
            letter-spacing: -3px;
            pointer-events: none;
        }

        .area-pesquisa label {
            position: relative;
            z-index: 1;
            display: block;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 2.5px;
            margin-bottom: 12px;
            color: #111;
        }

        .area-pesquisa .pesquisa-legenda {
            position: relative;
            z-index: 1;
            margin: -4px 0 18px;
            color: #666;
            font-size: 13px;
        }

        .form-pesquisa {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 10px;
            max-width: 980px;
        }

        .campo-pesquisa-wrap {
            position: relative;
            flex: 1;
        }

        .icone-pesquisa {
            position: absolute;
            left: 17px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 17px;
            z-index: 2;
        }

        .campo-pesquisa {
            width: 100%;
            box-sizing: border-box;
            height: 54px;
            padding: 0 18px 0 48px;
            border: 1px solid #c9c9c9;
            background: #fff;
            color: #111;
            font-size: 15px;
            outline: none;
            transition: .2s;
        }

        .campo-pesquisa::placeholder { color: #888; }
        .campo-pesquisa:focus {
            border-color: #111;
            box-shadow: 0 0 0 3px rgba(183,255,0,.55);
        }

        .botao-pesquisa {
            min-width: 130px;
            height: 54px;
            padding: 0 25px;
            border: 1px solid #111;
            background: #111;
            color: white;
            font-weight: 900;
            cursor: pointer;
            letter-spacing: 1.3px;
            transition: .2s;
        }

        .botao-pesquisa:hover {
            background: #b7ff00;
            color: #111;
            border-color: #b7ff00;
        }

        .botao-limpar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 54px;
            padding: 0 20px;
            box-sizing: border-box;
            background: #ddd;
            color: #111;
            text-decoration: none;
            font-weight: 900;
            font-size: 11px;
            letter-spacing: 1px;
            transition: .2s;
        }

        .botao-limpar:hover { background: #ff3cac; color: #fff; }


        /*
        |--------------------------------------------------------------------------
        | RESULTADO DA PESQUISA
        |--------------------------------------------------------------------------
        */

        .resultado-titulo {
            margin-bottom: 30px;
        }

        .resultado-titulo h2 {
            margin: 0 0 8px;
            font-size: 30px;
        }

        .resultado-titulo p {
            margin: 0;
            color: #666;
        }

        .resultado-vazio {
            padding: 40px;
            background: #f4f4f4;
            text-align: center;
            margin-bottom: 60px;
        }

        .resultado-vazio h2 {
            margin-top: 0;
        }

        .resultado-vazio a {
            display: inline-block;
            margin-top: 15px;
            padding: 13px 20px;
            background: #111;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }


        /*
        |--------------------------------------------------------------------------
        | CATEGORIAS
        |--------------------------------------------------------------------------
        */

        .categoria-produtos {
            margin-bottom: 65px;
        }

        .categoria-cabecalho {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .categoria-cabecalho h2 {
            font-size: 28px;
            margin: 0;
        }

        .categoria-cabecalho span {
            font-size: 13px;
            letter-spacing: 2px;
        }


        /*
        |--------------------------------------------------------------------------
        | CARDS DOS PRODUTOS
        |--------------------------------------------------------------------------
        */

        .produtos-scroll {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            overflow-y: hidden;
            scroll-behavior: smooth;
            padding: 5px 5px 20px;
            scrollbar-width: thin;
        }

        .produtos-scroll::-webkit-scrollbar {
            height: 7px;
        }

        .produto-card {
            flex: 0 0 260px;
            background: #f4f4f4;
            text-decoration: none;
            color: #111;
            transition: transform 0.2s ease;
        }

        .produto-card:hover {
            transform: translateY(-5px);
        }

        .produto-imagem-card {
            width: 100%;
            height: 290px;
            background: #e9e9e9;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .produto-imagem-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .sem-imagem {
            font-size: 55px;
        }

        .produto-card-info {
            padding: 18px;
        }

        .produto-card-categoria {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .produto-card-info h3 {
            font-size: 19px;
            margin: 8px 0;
        }

        .preco-antigo {
            color: #777;
            text-decoration: line-through;
            font-size: 13px;
            margin: 0;
        }

        .produto-preco {
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0 0;
        }

        .ver-produto {
            display: block;
            margin-top: 15px;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .produto-acoes {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 16px;
        }

        .produto-ver-btn, .produto-add-btn {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            text-decoration: none;
            font-size: 10px;
            font-weight: 900;
            letter-spacing: 1px;
            border: 1px solid #111;
            transition: .2s;
        }

        .produto-ver-btn { background: transparent; color: #111; }
        .produto-ver-btn:hover { background: #111; color: #fff; }
        .produto-add-btn { background: #b7ff00; color: #111; cursor: pointer; }
        .produto-add-btn:hover { background: #00d9ff; }
        .produto-add-btn:disabled { background: #ddd; color: #777; border-color: #ddd; cursor: not-allowed; }

        .sem-produtos {
            padding: 30px;
            background: #f4f4f4;
        }


        /*
        |--------------------------------------------------------------------------
        | BOTÃO VOLTAR
        |--------------------------------------------------------------------------
        */

        .voltar-inicio {
            display: inline-block;
            margin-bottom: 30px;
            color: #111;
            text-decoration: none;
            font-weight: bold;
        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 700px) {

            .produtos-pagina {
                padding: 40px 20px;
            }

            .form-pesquisa {
                flex-direction: column;
            }

            .area-pesquisa { padding: 22px; }
            .area-pesquisa:after { font-size: 34px; right: 15px; }
            .botao-pesquisa, .botao-limpar { width: 100%; }

            .botao-pesquisa,
            .botao-limpar {
                justify-content: center;
                text-align: center;
            }

            .produto-card {
                flex-basis: 220px;
            }

            .produto-imagem-card {
                height: 240px;
            }

            .categoria-cabecalho h2 {
                font-size: 22px;
            }

            .categoria-cabecalho span {
                font-size: 10px;
            }

        }

    </style>

</head>


<body>

<main class="produtos-pagina">


    <!-- VOLTAR PARA O INÍCIO -->

    <a href="index.php" class="voltar-inicio">
        ← Voltar para início
    </a>


    <!-- TÍTULO -->

    <section class="titulo-produtos">

        <span>SUA PACK / SHOP</span>

        <h1>
            TODOS OS<br>
            PRODUTOS
        </h1>

        <p>
            Explore nossas categorias e encontre produtos
            para montar sua própria vibe.
        </p>

    </section>


    <!-- =========================================================
         PESQUISA
    ========================================================== -->

    <section class="area-pesquisa">

        <label for="busca">
            ENCONTRE SUA PRÓXIMA VIBE
        </label>

        <p class="pesquisa-legenda">Busque por nome e encontre rapidamente o produto que combina com você.</p>

        <form
            action="produtos.php"
            method="GET"
            class="form-pesquisa"
        >

            <div class="campo-pesquisa-wrap">
                <span class="icone-pesquisa">⌕</span>
                <input
                    type="text"
                    id="busca"
                    name="busca"
                    class="campo-pesquisa"
                    placeholder="Ex.: mochila, chaveiro, boné..."
                    value="<?= htmlspecialchars($busca) ?>"
                >
            </div>

            <button
                type="submit"
                class="botao-pesquisa"
            >
                BUSCAR
            </button>

            <?php if ($busca != "") { ?>

                <a
                    href="produtos.php"
                    class="botao-limpar"
                >
                    LIMPAR
                </a>

            <?php } ?>

        </form>

    </section>


    <!-- =========================================================
         RESULTADOS DA PESQUISA
    ========================================================== -->

    <?php if ($busca != "") { ?>

        <?php if ($tem_resultados) { ?>

            <section class="resultado-titulo">

                <h2>
                    Resultados para:
                    "<?= htmlspecialchars($busca) ?>"
                </h2>

                <p>
                    Encontramos
                    <?= mysqli_num_rows($resultado_busca) ?>
                    produto(s).
                </p>

            </section>


            <section class="categoria-produtos">

                <div class="produtos-scroll">

                    <?php while ($produto = mysqli_fetch_assoc($resultado_busca)) { ?>

                        <?php

                        $preco = $produto["preco"];

                        $promocao = false;

                        if (
                            $produto["em_promocao"] == 1 &&
                            !empty($produto["preco_promocional"]) &&
                            $produto["preco_promocional"] > 0
                        ) {

                            $preco = $produto["preco_promocional"];

                            $promocao = true;

                        }

                        ?>

                        <article class="produto-card">

                            <div class="produto-imagem-card">

                                <?php if (!empty($produto["imagem"])) { ?>

                                    <img
                                        src="img/<?= htmlspecialchars($produto["imagem"]) ?>"
                                        alt="<?= htmlspecialchars($produto["nome"]) ?>"
                                    >

                                <?php } else { ?>

                                    <div class="sem-imagem">
                                        🛍️
                                    </div>

                                <?php } ?>

                            </div>


                            <div class="produto-card-info">

                                <span class="produto-card-categoria">

                                    <?= htmlspecialchars(
                                        $produto["categoria"] ?? "SUA PACK"
                                    ) ?>

                                </span>


                                <h3>
                                    <?= htmlspecialchars($produto["nome"]) ?>
                                </h3>


                                <?php if ($promocao) { ?>

                                    <p class="preco-antigo">

                                        R$
                                        <?= number_format(
                                            $produto["preco"],
                                            2,
                                            ",",
                                            "."
                                        ) ?>

                                    </p>

                                <?php } ?>


                                <p class="produto-preco">

                                    R$
                                    <?= number_format(
                                        $preco,
                                        2,
                                        ",",
                                        "."
                                    ) ?>

                                </p>

                            </div>

                            <div class="produto-acoes">
                                <a href="produto.php?id=<?= $produto["id_produto"] ?>" class="produto-ver-btn">VER PRODUTO</a>
                                <?php if ((int)$produto["estoque"] > 0) { ?>
                                    <form action="carrinho.php" method="POST" style="margin:0;">
                                        <input type="hidden" name="id_produto" value="<?= (int)$produto["id_produto"] ?>">
                                        <input type="hidden" name="quantidade" value="1">
                                        <button type="submit" name="adicionar" class="produto-add-btn">+ CARRINHO</button>
                                    </form>
                                <?php } else { ?>
                                    <button type="button" class="produto-add-btn" disabled>ESGOTADO</button>
                                <?php } ?>
                            </div>

                        </article>

                    <?php } ?>

                </div>

            </section>


        <?php } else { ?>


            <section class="resultado-vazio">

                <h2>
                    😕 Nenhum produto encontrado
                </h2>

                <p>
                    Não encontramos produtos para
                    "<strong><?= htmlspecialchars($busca) ?></strong>".
                </p>

                <a href="produtos.php">
                    VER TODOS OS PRODUTOS
                </a>

            </section>


        <?php } ?>


    <?php } else { ?>


        <!-- =====================================================
             TODAS AS CATEGORIAS
        ====================================================== -->


        <?php while ($categoria = mysqli_fetch_assoc($resultado_categorias)) { ?>


            <?php

            $id_categoria = $categoria["id_categoria"];

            $sql_produtos = "
                SELECT *
                FROM produtos
                WHERE id_categoria = $id_categoria
                ORDER BY id_produto DESC
            ";

            $resultado_produtos = mysqli_query(
                $conexao,
                $sql_produtos
            );

            ?>


            <section class="categoria-produtos">


                <div class="categoria-cabecalho">

                    <h2>
                        <?= htmlspecialchars($categoria["nome"]) ?>
                    </h2>

                    <span>
                        DESLIZE →
                    </span>

                </div>


                <?php if (
                    $resultado_produtos &&
                    mysqli_num_rows($resultado_produtos) > 0
                ) { ?>


                    <div class="produtos-scroll">


                        <?php while (
                            $produto = mysqli_fetch_assoc($resultado_produtos)
                        ) { ?>


                            <?php

                            $preco = $produto["preco"];

                            $promocao = false;

                            if (
                                $produto["em_promocao"] == 1 &&
                                !empty($produto["preco_promocional"]) &&
                                $produto["preco_promocional"] > 0
                            ) {

                                $preco = $produto["preco_promocional"];

                                $promocao = true;

                            }

                            ?>


                            <article class="produto-card">


                                <div class="produto-imagem-card">


                                    <?php if (!empty($produto["imagem"])) { ?>


                                        <img
                                            src="img/<?= htmlspecialchars($produto["imagem"]) ?>"
                                            alt="<?= htmlspecialchars($produto["nome"]) ?>"
                                        >


                                    <?php } else { ?>


                                        <div class="sem-imagem">
                                            🛍️
                                        </div>


                                    <?php } ?>


                                </div>


                                <div class="produto-card-info">


                                    <span class="produto-card-categoria">

                                        <?= htmlspecialchars(
                                            $categoria["nome"]
                                        ) ?>

                                    </span>


                                    <h3>

                                        <?= htmlspecialchars(
                                            $produto["nome"]
                                        ) ?>

                                    </h3>


                                    <?php if ($promocao) { ?>


                                        <p class="preco-antigo">

                                            R$
                                            <?= number_format(
                                                $produto["preco"],
                                                2,
                                                ",",
                                                "."
                                            ) ?>

                                        </p>


                                    <?php } ?>


                                    <p class="produto-preco">

                                        R$
                                        <?= number_format(
                                            $preco,
                                            2,
                                            ",",
                                            "."
                                        ) ?>

                                    </p>


                                </div>

                                <div class="produto-acoes">
                                    <a href="produto.php?id=<?= $produto["id_produto"] ?>" class="produto-ver-btn">VER PRODUTO</a>
                                    <?php if ((int)$produto["estoque"] > 0) { ?>
                                        <form action="carrinho.php" method="POST" style="margin:0;">
                                            <input type="hidden" name="id_produto" value="<?= (int)$produto["id_produto"] ?>">
                                            <input type="hidden" name="quantidade" value="1">
                                            <button type="submit" name="adicionar" class="produto-add-btn">+ CARRINHO</button>
                                        </form>
                                    <?php } else { ?>
                                        <button type="button" class="produto-add-btn" disabled>ESGOTADO</button>
                                    <?php } ?>
                                </div>

                            </article>


                        <?php } ?>


                    </div>


                <?php } else { ?>


                    <div class="sem-produtos">

                        Nenhum produto cadastrado nesta categoria ainda.

                    </div>


                <?php } ?>


            </section>


        <?php } ?>


    <?php } ?>


</main>

</body>

</html>
