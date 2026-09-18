<?php

include("../../conexao.php");

$sql = "SELECT * FROM categorias ORDER BY id_categoria DESC";

$resultado = mysqli_query($conexao, $sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Lista de Categorias - SUA PACK</title>
</head>

<body>

    <h1>Categorias</h1>

    <a href="cadastrar.php">+ Cadastrar Categoria</a>

    <br><br>

    <table border="1">

        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>

        <?php while ($categoria = mysqli_fetch_assoc($resultado)) { ?>

            <tr>

                <td>
                    <?= $categoria["id_categoria"] ?>
                </td>

                <td>
                    <?= $categoria["nome"] ?>
                </td>

                <td>
                    <a href="editar.php?id=<?= $categoria["id_categoria"] ?>">
                        Editar
                    </a>

                    |

                    <a href="excluir.php?id=<?= $categoria["id_categoria"] ?>">
                        Excluir
                    </a>
                </td>

            </tr>

        <?php } ?>

    </table>

</body>

</html>
