<?php
require_once "../../includes/auth.php";
exigir_admin();



include("../../conexao.php");

$sql = "SELECT produtos.*, categorias.nome AS categoria
        FROM produtos
        LEFT JOIN categorias
        ON produtos.id_categoria = categorias.id_categoria
        ORDER BY produtos.id_produto DESC";

$resultado = mysqli_query($conexao, $sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Produtos - SUA PACK</title>

    <link rel="stylesheet" href="../admin.css">

</head>

<body>

<header class="admin-header">

    <div class="logo">
        SUA <span>PACK</span>
    </div>

    <div class="admin-identificacao">

        <strong>
            Produtos
        </strong>

        <span class="status">
            Área Administrativa
        </span>

    </div>

    <a href="../index.php" class="voltar-site">
        ← Painel
    </a>

</header>


<main class="admin-container">

    <div class="boas-vindas">

        <h1>
            Produtos
        </h1>

        <p>
            Gerencie os produtos cadastrados na SUA PACK.
        </p>

    </div>


    <div class="admin-acoes">

        <a href="cadastrar.php" class="admin-btn">
            + Cadastrar Produto
        </a>

    </div>


    <div class="admin-tabela-container">

        <table class="admin-tabela">

            <thead>

                <tr>

                    <th>ID</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Promoção</th>
                    <th>Ações</th>

                </tr>

            </thead>


            <tbody>

                <?php while ($produto = mysqli_fetch_assoc($resultado)) { ?>

                    <tr>

                        <td class="admin-id">
                            <?= $produto["id_produto"] ?>
                        </td>


                        <td class="admin-produto-nome">

                            <?= htmlspecialchars($produto["nome"]) ?>

                        </td>


                        <td>

                            <?= htmlspecialchars(
                                $produto["categoria"] ?? "Sem categoria"
                            ) ?>

                        </td>


                        <td class="admin-preco">

                            R$ <?= number_format(
                                $produto["preco"],
                                2,
                                ",",
                                "."
                            ) ?>

                        </td>


                        <td class="admin-estoque">

                            <?= $produto["estoque"] ?>

                        </td>


                        <td>

                            <?php if ($produto["em_promocao"] == 1) { ?>

                                <span class="admin-status promocao">
                                    Sim
                                </span>

                            <?php } else { ?>

                                <span class="admin-status">
                                    Não
                                </span>

                            <?php } ?>

                        </td>


                        <td class="admin-acoes-tabela">

                            <a
                                href="editar.php?id=<?= $produto["id_produto"] ?>"
                                class="btn-editar"
                            >
                                Editar
                            </a>


                            <a
                                href="excluir.php?id=<?= $produto["id_produto"] ?>"
                                class="btn-excluir"
                                onclick="return confirm('Tem certeza que deseja excluir este produto?');"
                            >
                                Excluir
                            </a>

                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>


    <br>


    <a href="../index.php" class="voltar-site">
        ← Voltar ao painel
    </a>

</main>


<footer class="admin-footer">

    <p>
        SUA PACK — Área Administrativa
    </p>

</footer>


</body>

</html>