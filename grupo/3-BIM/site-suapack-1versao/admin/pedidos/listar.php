<?php

include("../../conexao.php");

$sql = "SELECT * FROM pedidos ORDER BY id_pedido DESC";

$resultado = mysqli_query($conexao, $sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pedidos | SUA PACK</title>

    <link rel="stylesheet" href="../admin.css">

</head>

<body>


<header class="admin-header">

    <div class="logo">
        SUA <span>PACK</span>
    </div>

    <div class="admin-identificacao">

        <strong>
            Pedidos
        </strong>

        <span class="status">
            Área Administrativa
        </span>

    </div>
    <link rel="stylesheet" href="../admin.css"> 
    <a href="../index.php" class="voltar-site">
        ← Painel
    </a>

</header>


<main class="admin-container">


    <div class="boas-vindas">

        <h1>
            Pedidos cadastrados
        </h1>

        <p>
            Gerencie os pedidos realizados na SUA PACK.
        </p>

    </div>


    <div class="admin-menu">

        <a href="cadastrar.php" class="admin-card">

            <div class="card-topo">

                <span class="icone">
                    ＋
                </span>

                <span class="card-label">
                    NOVO
                </span>

            </div>

            <div class="card-conteudo">

                <h2>
                    Cadastrar pedido
                </h2>

                <p>
                    Adicione um novo pedido.
                </p>

            </div>

            <div class="card-rodape">
                CADASTRAR →
            </div>

        </a>

    </div>


    <div class="tabela-container">

        <table>

            <thead>

                <tr>

                    <th>
                        ID
                    </th>

                    <th>
                        Cliente
                    </th>

                    <th>
                        Endereço
                    </th>

                    <th>
                        Pagamento
                    </th>

                    <th>
                        Total
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Ações
                    </th>

                </tr>

            </thead>


            <tbody>

                <?php while ($pedido = mysqli_fetch_assoc($resultado)) { ?>

                    <tr>

                        <td>
                            <?= $pedido["id_pedido"] ?>
                        </td>

                        <td>

                            <strong>
                                <?= htmlspecialchars($pedido["nome_cliente"]) ?>
                            </strong>

                        </td>

                        <td>
                            <?= htmlspecialchars($pedido["endereco"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($pedido["forma_pagamento"]) ?>
                        </td>

                        <td>

                            R$

                            <?= number_format(
                                $pedido["valor_total"],
                                2,
                                ",",
                                "."
                            ) ?>

                        </td>

                        <td>
                            <?= htmlspecialchars($pedido["status_pedido"]) ?>
                        </td>

                        <td>

                            <a href="visualizar.php?id=<?= $pedido["id_pedido"] ?>">
                                Ver
                            </a>

                            |

                            <a href="editar.php?id=<?= $pedido["id_pedido"] ?>">
                                Editar
                            </a>

                            |

                            <a
                                href="excluir.php?id=<?= $pedido["id_pedido"] ?>"
                                onclick="return confirm('Tem certeza que deseja excluir este pedido?');"
                            >
                                Excluir
                            </a>

                        </td>

                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>


</main>


<footer class="admin-footer">

    <p>
        SUA PACK — Área Administrativa
    </p>

</footer>


</body>

</html>
