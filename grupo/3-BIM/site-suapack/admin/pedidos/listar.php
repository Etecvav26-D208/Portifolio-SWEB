<?php

include("../../conexao.php");

$sql = "SELECT * FROM pedidos ORDER BY id_pedido DESC";

$resultado = mysqli_query($conexao, $sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Pedidos - SUA PACK</title>

</head>

<body>

    <h1>Pedidos</h1>

    <a href="cadastrar.php">
        + Cadastrar Pedido
    </a>

    <br><br>

    <table border="1">

        <tr>

            <th>ID</th>
            <th>Cliente</th>
            <th>Endereço</th>
            <th>Pagamento</th>
            <th>Valor Total</th>
            <th>Status</th>
            <th>Ações</th>

        </tr>


        <?php while ($pedido = mysqli_fetch_assoc($resultado)) { ?>

            <tr>

                <td>
                    <?= $pedido["id_pedido"] ?>
                </td>

                <td>
                    <?= $pedido["nome_cliente"] ?>
                </td>

                <td>
                    <?= $pedido["endereco"] ?>
                </td>

                <td>
                    <?= $pedido["forma_pagamento"] ?>
                </td>

                <td>
                    R$ <?= $pedido["valor_total"] ?>
                </td>

                <td>
                    <?= $pedido["status_pedido"] ?>
                </td>

                <td>

                    <a href="visualizar.php?id=<?= $pedido["id_pedido"] ?>">
                        Visualizar
                    </a>

                    |

                    <a href="editar.php?id=<?= $pedido["id_pedido"] ?>">
                        Editar
                    </a>

                    |

                    <a href="excluir.php?id=<?= $pedido["id_pedido"] ?>">
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
