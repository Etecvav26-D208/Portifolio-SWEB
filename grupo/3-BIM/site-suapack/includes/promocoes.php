<?php

include("../conexao.php");


/* Busca os produtos que estão em promoção */

$sql = "SELECT produtos.*, categorias.nome AS categoria
        FROM produtos
        LEFT JOIN categorias
        ON produtos.id_categoria = categorias.id_categoria
        WHERE produtos.em_promocao = 1
        ORDER BY produtos.id_produto DESC";


$resultado_promocoes = mysqli_query($conexao, $sql);

?>
