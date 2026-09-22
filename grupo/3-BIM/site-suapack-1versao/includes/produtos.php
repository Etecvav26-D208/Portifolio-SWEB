<?php

include(__DIR__ . "/../conexao.php");


/*
|--------------------------------------------------------------------------
| PRODUTOS EM DESTAQUE
|--------------------------------------------------------------------------
| Busca apenas 1 produto de cada categoria.
|--------------------------------------------------------------------------
*/

$sql_produtos = "
    SELECT
        produtos.*,
        categorias.nome AS categoria
    FROM produtos
    LEFT JOIN categorias
        ON produtos.id_categoria = categorias.id_categoria
    WHERE produtos.id_produto IN (
        SELECT MIN(id_produto)
        FROM produtos
        GROUP BY id_categoria
    )
    ORDER BY produtos.id_categoria ASC
";


/*
|--------------------------------------------------------------------------
| EXECUTAR CONSULTA
|--------------------------------------------------------------------------
*/

$resultado_produtos = mysqli_query(
    $conexao,
    $sql_produtos
);


/*
|--------------------------------------------------------------------------
| VERIFICAR ERRO
|--------------------------------------------------------------------------
*/

if (!$resultado_produtos) {

    die(
        "Erro ao buscar produtos em destaque: "
        . mysqli_error($conexao)
    );

}

?>