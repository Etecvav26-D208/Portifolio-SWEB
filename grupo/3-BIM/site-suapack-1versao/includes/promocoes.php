<?php

include(__DIR__ . "/../conexao.php");

$sql_promocoes = "
    SELECT 
        produtos.*,
        categorias.nome AS categoria
    FROM produtos
    LEFT JOIN categorias
        ON produtos.id_categoria = categorias.id_categoria
    WHERE produtos.em_promocao = 1
    AND produtos.preco_promocional IS NOT NULL
    AND produtos.preco_promocional > 0
    ORDER BY produtos.id_produto DESC
";

$resultado_promocoes = mysqli_query($conexao, $sql_promocoes);

?>
