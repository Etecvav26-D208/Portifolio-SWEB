<?php

include("../conexao.php");


/* Busca todos os produtos */

$sql = "SELECT produtos.*, categorias.nome AS categoria
        FROM produtos
        LEFT JOIN categorias
        ON produtos.id_categoria = categorias.id_categoria
        ORDER BY produtos.id_produto DESC";


$resultado_produtos = mysqli_query($conexao, $sql);

?>
