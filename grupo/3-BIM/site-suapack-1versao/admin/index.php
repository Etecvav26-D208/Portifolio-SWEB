
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SUA PACK | Painel Administrativo</title>

    <!-- Fonte principal do projeto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS do painel -->
    <link rel="stylesheet" href="admin.css">
</head>

<body>

    <!-- CABEÇALHO -->

    <header class="admin-header">

        <a href="../index.php" class="logo">
            SUA <span>PACK</span>
        </a>

        <div class="admin-identificacao">
            <span class="status"></span>
            PAINEL ADMIN
        </div>

        <a href="../index.php" class="voltar-site">
            ← Ver site
        </a>

    </header>


    <!-- CONTEÚDO PRINCIPAL -->

    <main class="admin-container">

        <section class="boas-vindas">

            <div>

                <span class="etiqueta">SUA PACK • CUSTOM STYLE</span>

                <h1>
                    PAINEL<br>
                    <span>ADMINISTRATIVO.</span>
                </h1>

                <p>
                    Gerencie os produtos, categorias e pedidos
                    da SUA PACK em um só lugar.
                </p>

            </div>

            <div class="admin-data">
                <span>ÁREA</span>
                <strong>01</strong>
            </div>

        </section>


        <!-- CARDS PRINCIPAIS -->

        <section class="admin-menu">

            <a href="produtos/listar.php" class="admin-card card-produtos">

                <div class="card-topo">
                    <span>01</span>
                    <span class="icone">↗</span>
                </div>

                <div class="card-conteudo">

                    <span class="card-label">GERENCIAMENTO</span>

                    <h2>PRODUTOS</h2>

                    <p>
                        Cadastre novos produtos, altere informações,
                        visualize o estoque e exclua produtos.
                    </p>

                </div>

                <div class="card-rodape">
                    <span>ACESSAR PRODUTOS</span>
                    <span>→</span>
                </div>

            </a>


            <a href="categorias/listar.php" class="admin-card card-categorias">

                <div class="card-topo">
                    <span>02</span>
                    <span class="icone">↗</span>
                </div>

                <div class="card-conteudo">

                    <span class="card-label">ORGANIZAÇÃO</span>

                    <h2>CATEGORIAS</h2>

                    <p>
                        Organize as categorias da loja e mantenha
                        os produtos separados por estilo.
                    </p>

                </div>

                <div class="card-rodape">
                    <span>ACESSAR CATEGORIAS</span>
                    <span>→</span>
                </div>

            </a>


            <a href="pedidos/listar.php" class="admin-card card-pedidos">

                <div class="card-topo">
                    <span>03</span>
                    <span class="icone">↗</span>
                </div>

                <div class="card-conteudo">

                    <span class="card-label">VENDAS</span>

                    <h2>PEDIDOS</h2>

                    <p>
                        Consulte os pedidos realizados e acompanhe
                        o status de cada compra.
                    </p>

                </div>

                <div class="card-rodape">
                    <span>ACESSAR PEDIDOS</span>
                    <span>→</span>
                </div>

            </a>

        </section>


        <!-- INFORMAÇÃO -->

        <section class="admin-info">

            <div class="info-numero">
                SUA<br>PACK
            </div>

            <div class="info-texto">
                <span>ORGANIZE • PERSONALIZE • VENDA</span>

                <p>
                    Este painel permite administrar as informações
                    que aparecem na loja para os clientes.
                </p>
            </div>

            <div class="info-status">
                <span class="bolinha"></span>
                SISTEMA ONLINE
            </div>

        </section>

    </main>


    <!-- RODAPÉ -->

    <footer class="admin-footer">

        <span>© 2026 SUA PACK</span>

        <span>CUSTOM STYLE / ADMIN</span>

        <a href="../index.php">VOLTAR PARA A LOJA →</a>

    </footer>

</body>

</html>
