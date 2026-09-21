
<?php

include("includes/produtos.php");
include("includes/promocoes.php");
include("includes/categorias.php");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SUA PACK | Custom Style</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="style.css">

</head>

<body>


    <!-- ========================================= -->
    <!-- CABEÇALHO -->
    <!-- ========================================= -->

    <header class="header">

        <div class="logo">
            SUA <span>PACK</span>
        </div>


        <nav class="menu">

            <a href="#inicio">
                Início
            </a>

            <a href="#categorias">
                Categorias
            </a>

            <a href="#promocoes">
                Promoções
            </a>

            <a href="#destaques">
                Destaques
            </a>

        </nav>


        <a href="carrinho.php" class="carrinho">
            🛒
        </a>

    </header>



    <main>


        <!-- ========================================= -->
        <!-- INÍCIO -->
        <!-- ========================================= -->

        <section class="hero" id="inicio">


            <div class="hero-texto">

                <p class="tag">
                    CUSTOM STYLE • STREET CULTURE
                </p>


                <h1>

                    SEU ESTILO.<br>

                    SUA <span>PACK.</span>

                </h1>


                <p class="descricao">

                    Mochilas e acessórios personalizados
                    para quem quer transformar seu estilo
                    em algo único.

                </p>


                <a href="#categorias" class="botao">

                    VER PRODUTOS

                </a>

            </div>



            <div class="hero-imagem">

                <div class="imagem-destaque">

                    SUA<br>
                    PACK

                </div>

            </div>


        </section>



        <!-- ========================================= -->
        <!-- SOBRE A MARCA -->
        <!-- ========================================= -->

        <section class="sobre">


            <p class="titulo-pequeno">

                SOBRE A MARCA

            </p>


            <h2>

                NÃO É SÓ UMA MOCHILA.
                <span>É SUA IDENTIDADE.</span>

            </h2>


            <p>

                A SUA PACK nasceu para jovens que gostam
                de criatividade, autenticidade e moda urbana.

                Nossos produtos unem cultura pop,
                streetwear e personalização para que
                cada pessoa possa montar sua própria vibe.

            </p>


        </section>



        <!-- ========================================= -->
        <!-- CATEGORIAS -->
        <!-- ========================================= -->

        <section class="categorias" id="categorias">


            <div class="titulo-secao">

                <p>
                    ESCOLHA SUA VIBE
                </p>

                <h2>
                    CATEGORIAS
                </h2>

            </div>



            <div class="grade-categorias">


                <?php

                $numero = 1;

                while ($categoria = mysqli_fetch_assoc($resultado_categorias)) {

                ?>


                    <a href="#produtos" class="categoria-card">


                        <span class="numero">

                            <?= str_pad($numero, 2, "0", STR_PAD_LEFT) ?>

                        </span>


                        <div>

                            <p>
                                SUA PACK
                            </p>


                            <h3>

                                <?= htmlspecialchars($categoria["nome"]) ?>

                            </h3>


                            <span>

                                VER PRODUTOS →

                            </span>

                        </div>


                    </a>


                <?php

                    $numero++;

                }

                ?>


            </div>


        </section>



        <!-- ========================================= -->
        <!-- PROMOÇÕES -->
        <!-- ========================================= -->

        <section class="promocoes" id="promocoes">


            <div class="promo-banner">


                <div class="promo-texto">


                    <p class="promo-tag">

                        DROP SALE

                    </p>


                    <h2>

                        SUA VIBE,<br>

                        <span>MENOS CARA.</span>

                    </h2>


                    <p class="promo-descricao">

                        Produtos selecionados com descontos
                        especiais por tempo limitado.

                    </p>


                    <a href="#ofertas" class="promo-botao">

                        VER PROMOÇÕES →

                    </a>


                </div>



                <div class="promo-destaque">


                    <span>
                        ATÉ
                    </span>


                    <strong>
                        30%
                    </strong>


                    <span>
                        OFF
                    </span>


                </div>


            </div>



            <!-- PRODUTOS EM PROMOÇÃO -->

            <div class="ofertas" id="ofertas">


                <?php while ($produto = mysqli_fetch_assoc($resultado_promocoes)) { ?>


                    <?php

                    $desconto = 0;


                    if (
                        $produto["preco"] > 0 &&
                        !empty($produto["preco_promocional"])
                    ) {

                        $desconto =
                            (
                                (
                                    $produto["preco"] -
                                    $produto["preco_promocional"]
                                )
                                /
                                $produto["preco"]
                            )
                            * 100;

                    }

                    ?>


                    <article class="oferta-card">


                        <!-- IMAGEM -->

                        <div class="oferta-imagem">


                            <?php if (!empty($produto["imagem"])) { ?>


                                <img
                                    src="img/<?= htmlspecialchars($produto["imagem"]) ?>"
                                    alt="<?= htmlspecialchars($produto["nome"]) ?>"
                                >


                            <?php } else { ?>


                                <span>
                                    FOTO
                                </span>


                            <?php } ?>


                        </div>



                        <!-- DESCONTO -->

                        <span class="desconto">

                            -<?= number_format($desconto, 0) ?>%

                        </span>



                        <!-- CATEGORIA -->

                        <p class="produto-categoria">

                            <?= htmlspecialchars($produto["categoria"]) ?>

                        </p>



                        <!-- NOME -->

                        <h3>

                            <?= htmlspecialchars($produto["nome"]) ?>

                        </h3>



                        <!-- PREÇOS -->

                        <div class="precos">


                            <span class="preco-antigo">

                                R$

                                <?= number_format(
                                    $produto["preco"],
                                    2,
                                    ",",
                                    "."
                                ) ?>

                            </span>



                            <span class="preco-promocional">

                                R$

                                <?= number_format(
                                    $produto["preco_promocional"],
                                    2,
                                    ",",
                                    "."
                                ) ?>

                            </span>


                        </div>



                        <a href="#">

                            VER PRODUTO →

                        </a>


                    </article>


                <?php } ?>


            </div>


        </section>



        <!-- ========================================= -->
        <!-- PRODUTOS EM DESTAQUE -->
        <!-- ========================================= -->

        <section class="destaques" id="destaques">


            <div class="titulo-secao">

                <p>
                    SUA PACK PICKS
                </p>

                <h2>
                    DESTAQUES
                </h2>

            </div>



            <div class="grade-produtos" id="produtos">


                <?php while ($produto = mysqli_fetch_assoc($resultado_produtos)) { ?>


                    <article class="produto">


                        <!-- IMAGEM -->

                        <div class="produto-imagem">


                            <?php if (!empty($produto["imagem"])) { ?>


                                <img
                                    src="img/<?= htmlspecialchars($produto["imagem"]) ?>"
                                    alt="<?= htmlspecialchars($produto["nome"]) ?>"
                                >


                            <?php } else { ?>


                                <span>
                                    FOTO
                                </span>


                            <?php } ?>


                        </div>



                        <!-- CATEGORIA -->

                        <p class="produto-categoria">

                            <?= htmlspecialchars($produto["categoria"]) ?>

                        </p>



                        <!-- NOME -->

                        <h3>

                            <?= htmlspecialchars($produto["nome"]) ?>

                        </h3>



                        <!-- PREÇO -->

                        <?php

                        if (
                            $produto["em_promocao"] == 1 &&
                            !empty($produto["preco_promocional"])
                        ) {

                        ?>


                            <p class="preco">

                                R$

                                <?= number_format(
                                    $produto["preco_promocional"],
                                    2,
                                    ",",
                                    "."
                                ) ?>

                            </p>


                        <?php

                        } else {

                        ?>


                            <p class="preco">

                                R$

                                <?= number_format(
                                    $produto["preco"],
                                    2,
                                    ",",
                                    "."
                                ) ?>

                            </p>


                        <?php

                        }

                        ?>


                        <a href="produtos.php">

                            VER PRODUTO

                        </a>


                    </article>


                <?php } ?>


            </div>


        </section>



        <!-- ========================================= -->
        <!-- CHAMADA FINAL -->
        <!-- ========================================= -->

        <section class="sobre">


            <p class="titulo-pequeno">

                MONTE SUA VIBE

            </p>


            <h2>

                SEU ESTILO.
                <span>SUAS REGRAS.</span>

            </h2>


            <p>

                Escolha sua mochila, personalize com seus
                acessórios favoritos e crie uma combinação
                que tenha a sua cara.

            </p>


            <a href="#categorias" class="botao">

                COMEÇAR AGORA

            </a>


        </section>


    </main>



    <!-- ========================================= -->
    <!-- RODAPÉ -->
    <!-- ========================================= -->

    <footer class="footer">


        <div class="footer-logo">

            SUA <span>PACK</span>

        </div>


        <p>

            Seu estilo. Sua identidade. Sua Pack.

        </p>



        <div class="redes">


            <a href="#">
                Instagram
            </a>


            <a href="#">
                TikTok
            </a>


            <a href="#">
                Pinterest
            </a>


        </div>



        <p class="copyright">

            © 2026 SUA PACK — CUSTOM STYLE

        </p>


    </footer>


</body>

</html>
