<?php
require_once "../../includes/auth.php";
exigir_admin();



include("../../conexao.php");

$sql = "SELECT * FROM categorias ORDER BY id_categoria DESC";

$resultado = mysqli_query($conexao, $sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Categorias | SUA PACK</title>

    <link rel="stylesheet" href="../admin.css">

</head>

<body>

<header class="admin-header">

    <div class="logo">
        SUA <span>PACK</span>
    </div>

    <div class="admin-identificacao">

        <strong>
            Categorias
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
            Categorias cadastradas
        </h1>

        <p>
            Gerencie as categorias dos produtos.
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
                    Cadastrar categoria
                </h2>

                <p>
                    Adicione uma nova categoria.
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
                        Nome da categoria
                    </th>

                    <th>
                        Ações
                    </th>

                </tr>

            </thead>

            <tbody>

                <?php while ($categoria = mysqli_fetch_assoc($resultado)) { ?>

                    <tr>

                        <td>
                            <?= $categoria["id_categoria"] ?>
                        </td>

                        <td>

                            <strong>
                                <?= htmlspecialchars($categoria["nome"]) ?>
                            </strong>

                        </td>

                        <td>

                            <a href="editar.php?id=<?= $categoria["id_categoria"] ?>">
                                Editar
                            </a>

                            |

                            <a
                                href="excluir.php?id=<?= $categoria["id_categoria"] ?>"
                                onclick="return confirm('Tem certeza que deseja excluir esta categoria?');"
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
