<?php
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
            margin-bottom: 60px;
            padding: 25px;
            background: #f4f4f4;
        }

        .area-pesquisa label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        .form-pesquisa {
            display: flex;
            gap: 10px;
            max-width: 800px;
        }

        .campo-pesquisa {
            flex: 1;
            padding: 15px 18px;
            border: 1px solid #ccc;
            background: white;
            font-size: 15px;
            outline: none;
        }

        .campo-pesquisa:focus {
            border-color: #111;
        }

        .botao-pesquisa {
            padding: 15px 25px;
            border: none;
            background: #111;
            color: white;
            font-weight: bold;
            cursor: pointer;
            letter-spacing: 1px;
        }

        .botao-pesquisa:hover {
            opacity: 0.85;
        }

        .botao-limpar {
            display: inline-flex;
            align-items: center;
            padding: 15px 20px;
            background: #ddd;
            color: #111;
            text-decoration: none;
            font-weight: bold;
        }

        .botao-limpar:hover {
            background: #ccc;
        }


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
            🔎 O QUE VOCÊ ESTÁ PROCURANDO?
        </label>

        <form
            action="produtos.php"
            method="GET"
            class="form-pesquisa"
        >

            <input
                type="text"
                id="busca"
                name="busca"
                class="campo-pesquisa"
                placeholder="Digite o nome do produto..."
                value="<?= htmlspecialchars($busca) ?>"
            >

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

                        <a
                            href="produto.php?id=<?= $produto["id_produto"] ?>"
                            class="produto-card"
                        >

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


                                <span class="ver-produto">
                                    VER PRODUTO →
                                </span>

                            </div>

                        </a>

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


                            <a
                                href="produto.php?id=<?= $produto["id_produto"] ?>"
                                class="produto-card"
                            >


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


                                    <span class="ver-produto">

                                        VER PRODUTO →

                                    </span>


                                </div>


                            </a>


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
