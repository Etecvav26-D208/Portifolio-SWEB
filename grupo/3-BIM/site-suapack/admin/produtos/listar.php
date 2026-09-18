<?php

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

    <title>Produtos - SUA PACK</title>

</head>

<body>

    <h1>Produtos</h1>

    <a href="cadastrar.php">
        + Cadastrar Produto
    </a>

    <br><br>

    <table border="1">

        <tr>

            <th>ID</th>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Promoção</th>
            <th>Ações</th>

        </tr>

        <?php while ($produto = mysqli_fetch_assoc($resultado)) { ?>

            <tr>

                <td>
                    <?= $produto["id_produto"] ?>
                </td>

                <td>
                    <?= $produto["nome"] ?>
                </td>

                <td>
                    <?= $produto["categoria"] ?>
                </td>

                <td>
                    R$ <?= $produto["preco"] ?>
                </td>

                <td>
                    <?= $produto["estoque"] ?>
                </td>

                <td>

                    <?php if ($produto["em_promocao"] == 1) { ?>

                        Sim

                    <?php } else { ?>

                        Não

                    <?php } ?>

                </td>

                <td>

                    <a href="editar.php?id=<?= $produto["id_produto"] ?>">
                        Editar
                    </a>

                    |

                    <a href="excluir.php?id=<?= $produto["id_produto"] ?>">
                        Excluir
                    </a>

                </td>

            </tr>

        <?php } ?>

    </table>

    <br>

    <a href="../index.php">
        Voltar ao painel
    </a>

</body>

</html>
