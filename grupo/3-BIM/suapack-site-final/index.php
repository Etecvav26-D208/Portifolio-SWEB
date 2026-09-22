<?php
require_once "includes/auth.php";
bloquear_admin_na_loja("admin/index.php");
include("includes/produtos.php");
include("includes/promocoes.php");
include("includes/categorias.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUA PACK | Seu estilo. Sua Pack.</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="home-page">

<header class="header home-header">
    <div class="logo">
        <a href="index.php" aria-label="SUA PACK - Início">
            <img src="img/logo-sua-pack.svg" alt="SUA PACK">
        </a>
    </div>
    <nav class="home-nav" aria-label="Navegação principal">
        <a href="#sobre">SOBRE</a>
        <a href="#categorias">CATEGORIAS</a>
        <a href="#ofertas">OFERTAS</a>
        <a href="produtos.php">LOJA</a>
    </nav>
    <div class="header-acoes">
        <a href="<?= usuario_logado() ? 'perfil.php' : 'login.php' ?>" class="usuario-icone" aria-label="<?= usuario_logado() ? 'Meu perfil' : 'Entrar na conta' ?>" title="<?= usuario_logado() ? 'Meu perfil' : 'Entrar na conta' ?>">
            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="3.2"></circle><path d="M5.5 20c.8-3.1 3.1-5 6.5-5s5.7 1.9 6.5 5"></path></svg>
            <?php if (usuario_logado()): ?><span class="usuario-status" aria-hidden="true"></span><?php endif; ?>
        </a>
        <a href="carrinho.php" class="carrinho" aria-label="Abrir carrinho" title="Carrinho">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5h2l1.5 10h9.7L20 8H7"></path><circle cx="10" cy="19" r="1.3"></circle><circle cx="17" cy="19" r="1.3"></circle></svg>
        </a>
    </div>
</header>

<main>
    <section class="home-hero">
        <div class="hero-shape hero-shape-a"></div>
        <div class="hero-shape hero-shape-b"></div>
        <div class="hero-grid"></div>
        <div class="home-hero-copy">
            <div class="eyebrow"><span></span> URBAN STORE • 2026</div>
            <h1>SEU ESTILO.<br><em>SUA PACK.</em></h1>
            <p>Moda urbana, mochilas, acessórios e peças com personalidade para você carregar o seu estilo por onde for.</p>
            <div class="home-actions">
                <a href="produtos.php" class="home-btn home-btn-yellow">COMPRAR AGORA <b>↗</b></a>
                <a href="#sobre" class="home-btn home-btn-outline">CONHECER A MARCA</a>
            </div>
            <div class="hero-stamps"><span>MOCHILAS</span><span>ACESSÓRIOS</span><span>CULTURA POP</span><span>CUSTOM</span></div>
        </div>
        <div class="home-hero-art">
            <div class="art-ring art-ring-one"></div>
            <div class="art-ring art-ring-two"></div>
            <div class="art-note">SEU<br>ESTILO<br><strong>↘</strong></div>
            <img src="img/logo-graffiti.jpg" alt="Logo gráfica SUA PACK" class="hero-brand-art">
            <div class="art-card art-card-a"><img src="img/mochila_azul_aqua.png" alt="Mochila Azul Aqua"></div>
            <div class="art-card art-card-b"><img src="img/bolsa_urban.jpeg" alt="Bolsa Urban"></div>
        </div>
    </section>

    <div class="home-marquee"><div>SEU ESTILO • SUA PACK • LEVANDO SEU ESTILO COM VOCÊ • SEU ESTILO • SUA PACK •</div></div>

    <section id="sobre" class="home-about">
        <div class="about-art"><img src="img/logo-graffiti-2.jpg" alt="SUA PACK - Levando seu estilo com você"></div>
        <div class="about-copy">
            <div class="section-kicker">01 / SOBRE A SUA PACK</div>
            <h2>Não é só uma mochila.<br><span>É atitude.</span></h2>
            <p>A SUA PACK nasceu para transformar acessórios em extensão da personalidade. A ideia é simples: produtos urbanos, visuais marcantes e espaço para cada pessoa criar seu próprio estilo.</p>
            <div class="about-pills"><span>URBANO</span><span>CRIATIVO</span><span>AUTÊNTICO</span></div>
            <a href="produtos.php" class="text-arrow">EXPLORAR A LOJA →</a>
        </div>
    </section>

    <section id="categorias" class="home-categories">
        <div class="home-section-head"><div><div class="section-kicker">02 / ESCOLHA SUA VIBE</div><h2>Qual é o seu <span>estilo?</span></h2></div><a href="produtos.php">VER TUDO →</a></div>
        <div class="category-grid">
            <a class="category-card cat-green" href="produtos.php"><div class="cat-number">01</div><div class="cat-image"><img src="img/mochila_custom_style.jpeg" alt="Mochilas"></div><div><small>PARA CARREGAR SUA VIBE</small><h3>MOCHILAS</h3></div></a>
            <a class="category-card cat-yellow" href="produtos.php"><div class="cat-number">02</div><div class="cat-image"><img src="img/bone_streetwear_amarelo.jpeg" alt="Bonés"></div><div><small>DETALHE QUE MUDA O LOOK</small><h3>BONÉS</h3></div></a>
            <a class="category-card cat-pink" href="produtos.php"><div class="cat-number">03</div><div class="cat-image"><img src="img/chaveiro-colorido-good-vibes.jpeg" alt="Chaveiros"></div><div><small>PEQUENO, MAS CHEIO DE ATITUDE</small><h3>CHAVEIROS</h3></div></a>
            <a class="category-card cat-blue" href="produtos.php"><div class="cat-number">04</div><div class="cat-image"><img src="img/adesivo_pack_1.png" alt="Adesivos"></div><div><small>PERSONALIZE DO SEU JEITO</small><h3>ADESIVOS</h3></div></a>
        </div>
    </section>

    <section id="ofertas" class="home-promos">
        <div class="home-section-head light"><div><div class="section-kicker">03 / DROP DA VEZ</div><h2>Achados que <span>valem o look.</span></h2></div><a href="produtos.php">VER PRODUTOS →</a></div>
        <div class="home-product-grid">
            <?php if (isset($resultado_promocoes) && mysqli_num_rows($resultado_promocoes) > 0): ?>
                <?php while ($produto = mysqli_fetch_assoc($resultado_promocoes)): ?>
                    <?php
                    $preco_original = (float)$produto["preco"];
                    $preco_promocional = (float)$produto["preco_promocional"];
                    $desconto = ($preco_original > 0 && $preco_promocional > 0) ? (($preco_original - $preco_promocional) / $preco_original) * 100 : 0;
                    ?>
                    <article class="home-product-card">
                        <a href="produto.php?id=<?= (int)$produto["id_produto"] ?>" class="home-product-image">
                            <?php if (!empty($produto["imagem"])): ?><img src="img/<?= htmlspecialchars($produto["imagem"]) ?>" alt="<?= htmlspecialchars($produto["nome"]) ?>"><?php else: ?><span>SEM IMAGEM</span><?php endif; ?>
                            <?php if ($desconto > 0): ?><b class="sale-badge">-<?= round($desconto) ?>%</b><?php endif; ?>
                        </a>
                        <div class="home-product-info"><small><?= htmlspecialchars($produto["categoria"]) ?></small><h3><?= htmlspecialchars($produto["nome"]) ?></h3><div><del>R$ <?= number_format($preco_original,2,",",".") ?></del><strong>R$ <?= number_format($preco_promocional,2,",",".") ?></strong></div><a href="produto.php?id=<?= (int)$produto["id_produto"] ?>">VER PRODUTO →</a></div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-home">Nenhum produto em promoção no momento.</div>
            <?php endif; ?>
        </div>
    </section>

    <section class="home-featured">
        <div class="featured-copy"><div class="section-kicker">04 / DESTAQUES</div><h2>Monte sua<br><span>própria vibe.</span></h2><p>Escolha uma peça. Misture cores. Adicione personalidade. A SUA PACK acompanha você no seu ritmo.</p><a href="produtos.php" class="home-btn home-btn-dark">VER TODOS OS PRODUTOS ↗</a></div>
        <div class="featured-products">
            <?php if (isset($resultado_produtos) && mysqli_num_rows($resultado_produtos) > 0): ?>
                <?php $home_count = 0; while ($produto = mysqli_fetch_assoc($resultado_produtos)): if ($home_count >= 3) break; $home_count++; ?>
                    <?php $preco = (!empty($produto["em_promocao"]) && !empty($produto["preco_promocional"]) && $produto["preco_promocional"] > 0) ? $produto["preco_promocional"] : $produto["preco"]; ?>
                    <a class="featured-product" href="produto.php?id=<?= (int)$produto["id_produto"] ?>">
                        <div class="featured-img"><?php if (!empty($produto["imagem"])): ?><img src="img/<?= htmlspecialchars($produto["imagem"]) ?>" alt="<?= htmlspecialchars($produto["nome"]) ?>"><?php endif; ?></div>
                        <small><?= htmlspecialchars($produto["categoria"]) ?></small><h3><?= htmlspecialchars($produto["nome"]) ?></h3><strong>R$ <?= number_format($preco,2,",",".") ?></strong>
                    </a>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="home-cta">
        <div class="cta-scribble">✦</div><div class="section-kicker">05 / SUA VEZ</div><h2>Seu estilo não cabe<br>em qualquer lugar.</h2><p>Então escolha uma SUA PACK e leva a sua vibe com você.</p><a href="produtos.php" class="home-btn home-btn-black">COMEÇAR A COMPRAR →</a>
    </section>
</main>

<footer class="home-footer">
    <div class="footer-brand"><img src="img/logo-sua-pack.svg" alt="SUA PACK"><p>SEU ESTILO. SUA PACK.</p></div>
    <div class="footer-nav"><a href="index.php">INÍCIO</a><a href="#sobre">SOBRE</a><a href="produtos.php">PRODUTOS</a><a href="carrinho.php">CARRINHO</a><?php if (usuario_logado()): ?><a href="perfil.php">PERFIL</a><?php else: ?><a href="login.php">ENTRAR</a><?php endif; ?></div>
    <div class="footer-copy">© <?= date("Y") ?> SUA PACK — URBAN STORE</div>
</footer>

</body>
</html>
