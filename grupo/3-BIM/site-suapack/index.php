
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

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- CABEÇALHO -->
    <header class="header">

        <div class="logo">
            <a href="index.php">SUA PACK</a>
        </div>

        <a href="carrinho.php" class="carrinho">🛒</a>

    </header>


    <!-- INÍCIO / BANNER -->
    <section id="inicio" class="hero">

        <div class="hero-content">

            <p class="hero-small">CUSTOM STYLE</p>

            <h1>
                SEU ESTILO.<br>
                SUA PACK.
            </h1>

            <p>
                Moda urbana, acessórios e produtos personalizados
                para você criar seu próprio estilo.
            </p>

            <a href="#categorias" class="btn">
                COMPRAR AGORA
            </a>

        </div>

    </section>


    <!-- SOBRE -->
    <section id="sobre" class="sobre">

        <div class="sobre-content">

            <p class="section-small">
                SOBRE A SUA PACK
            </p>

            <h2>
                MAIS QUE UM ACESSÓRIO.<br>
                É O SEU ESTILO.
            </h2>

            <p>
                A SUA PACK nasceu para quem gosta de se expressar
                através da moda e da criatividade.
            </p>

            <p>
                Aqui você encontra mochilas, bonés, chaveiros,
                adesivos e pulseiras para montar combinações
                do seu jeito.
            </p>

            <p>
                Nossa proposta é unir moda urbana, criatividade
                e personalidade em um só lugar.
            </p>

        </div>

    </section>


    <!-- CATEGORIAS -->
    <section id="categorias" class="categorias">

        <div class="section-title">

            <p>CATEGORIAS</p>

            <h2>
                ESCOLHA SEU ESTILO
            </h2>

        </div>


        <div class="categorias-grid">

            <?php if (isset($resultado_categorias) && mysqli_num_rows($resultado_categorias) > 0): ?>

                <?php while ($categoria = mysqli_fetch_assoc($resultado_categorias)): ?>

                    <a
                        href="produtos.php?id_categoria=<?= $categoria["id_categoria"] ?>"
                        class="categoria-card"
                    >

                        <div class="categoria-content">

                            <span>
                                SUA PACK
                            </span>

                            <h3>
                                <?= htmlspecialchars($categoria["nome"]) ?>
                            </h3>

                            <p>
                                VER PRODUTOS →
                            </p>

                        </div>

                    </a>

                <?php endwhile; ?>

            <?php else: ?>

                <p>
                    Nenhuma categoria cadastrada.
                </p>

            <?php endif; ?>

        </div>

    </section>


    <!-- PROMOÇÕES -->
    <section id="promocoes" class="promocoes">

        <div class="section-title">

            <p>OFERTAS</p>

            <h2>
                PROMOÇÕES
            </h2>

        </div>


        <div class="produtos-grid">

            <?php if (isset($resultado_promocoes) && mysqli_num_rows($resultado_promocoes) > 0): ?>

                <?php while ($produto = mysqli_fetch_assoc($resultado_promocoes)): ?>

                    <?php

                    $preco_original = $produto["preco"];
                    $preco_promocional = $produto["preco_promocional"];

                    $desconto = 0;

                    if ($preco_original > 0 && $preco_promocional > 0) {
                        $desconto = (($preco_original - $preco_promocional) / $preco_original) * 100;
                    }

                    ?>

                    <div class="produto-card">

                        <div class="produto-imagem">

                            <?php if (!empty($produto["imagem"])): ?>

                                <img
                                    src="img/<?= htmlspecialchars($produto["imagem"]) ?>"
                                    alt="<?= htmlspecialchars($produto["nome"]) ?>"
                                >

                            <?php else: ?>

                                <div class="sem-imagem">
                                    SEM IMAGEM
                                </div>

                            <?php endif; ?>


                            <?php if ($desconto > 0): ?>

                                <span class="desconto">
                                    -<?= round($desconto) ?>%
                                </span>

                            <?php endif; ?>

                        </div>


                        <div class="produto-info">

                            <p class="produto-categoria">
                                <?= htmlspecialchars($produto["categoria"]) ?>
                            </p>

                            <h3>
                                <?= htmlspecialchars($produto["nome"]) ?>
                            </h3>


                            <div class="produto-precos">

                                <span class="preco-antigo">
                                    R$ <?= number_format($preco_original, 2, ",", ".") ?>
                                </span>

                                <span class="preco">
                                    R$ <?= number_format($preco_promocional, 2, ",", ".") ?>
                                </span>

                            </div>


                            <a
                                href="produto.php?id=<?= $produto["id_produto"] ?>"
                                class="produto-link"
                            >
                                VER PRODUTO
                            </a>

                        </div>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <p>
                    Nenhum produto em promoção no momento.
                </p>

            <?php endif; ?>

        </div>

    </section>


    <!-- DESTAQUES -->
    <section id="destaques" class="destaques">

        <div class="section-title">

            <p>PRODUTOS</p>

            <h2>
                DESTAQUES
            </h2>

        </div>


        <div class="produtos-grid">

            <?php if (isset($resultado_produtos) && mysqli_num_rows($resultado_produtos) > 0): ?>

                <?php while ($produto = mysqli_fetch_assoc($resultado_produtos)): ?>

                    <?php

                    $preco = $produto["preco"];

                    if (
                        !empty($produto["em_promocao"]) &&
                        !empty($produto["preco_promocional"]) &&
                        $produto["preco_promocional"] > 0
                    ) {
                        $preco = $produto["preco_promocional"];
                    }

                    ?>

                    <div class="produto-card">

                        <div class="produto-imagem">

                            <?php if (!empty($produto["imagem"])): ?>

                                <img
                                    src="img/<?= htmlspecialchars($produto["imagem"]) ?>"
                                    alt="<?= htmlspecialchars($produto["nome"]) ?>"
                                >

                            <?php else: ?>

                                <div class="sem-imagem">
                                    SEM IMAGEM
                                </div>

                            <?php endif; ?>

                        </div>


                        <div class="produto-info">

                            <p class="produto-categoria">
                                <?= htmlspecialchars($produto["categoria"]) ?>
                            </p>

                            <h3>
                                <?= htmlspecialchars($produto["nome"]) ?>
                            </h3>


                            <span class="preco">
                                R$ <?= number_format($preco, 2, ",", ".") ?>
                            </span>


                            <a
                                href="produto.php?id=<?= $produto["id_produto"] ?>"
                                class="produto-link"
                            >
                                VER PRODUTO
                            </a>

                        </div>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <p>
                    Nenhum produto cadastrado.
                </p>

            <?php endif; ?>

        </div>


        <div class="ver-todos">

            <a href="produtos.php" class="btn">
                VER TODOS OS PRODUTOS
            </a>

        </div>

    </section>


    <!-- CHAMADA FINAL -->
    <section class="cta">

        <div class="cta-content">

            <p>
                CUSTOM STYLE
            </p>

            <h2>
                CRIE. PERSONALIZE.<br>
                USE DO SEU JEITO.
            </h2>

            <a href="produtos.php" class="btn">
                CONHECER PRODUTOS
            </a>

        </div>

    </section>


    <!-- RODAPÉ -->
    <footer class="footer">

        <div class="footer-content">

            <div class="footer-logo">

                <h2>
                    SUA PACK
                </h2>

                <p>
                    Custom Style
                </p>

            </div>


            <div class="footer-links">

                <h3>
                    NAVEGAÇÃO
                </h3>

                <a href="index.php">
                    Início
                </a>

                <a href="#sobre">
                    Sobre
                </a>

                <a href="produtos.php">
                    Produtos
                </a>

                <a href="carrinho.php">
                    Carrinho
                </a>

            </div>


            <div class="footer-links">

                <h3>
                    CATEGORIAS
                </h3>

                <a href="produtos.php">
                    Mochilas
                </a>

                <a href="produtos.php">
                    Bonés
                </a>

                <a href="produtos.php">
                    Chaveiros
                </a>

                <a href="produtos.php">
                    Adesivos
                </a>

                <a href="produtos.php">
                    Pulseiras
                </a>

            </div>

        </div>


        <div class="footer-bottom">

            <p>
                © <?= date("Y") ?> SUA PACK — Todos os direitos reservados.
            </p>

        </div>

    </footer>

</body>

</html>
