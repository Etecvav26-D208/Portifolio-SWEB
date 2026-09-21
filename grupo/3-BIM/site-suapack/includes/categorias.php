<?php

include(__DIR__ . "/../conexao.php");


/* Busca todas as categorias */

$sql = "SELECT * FROM categorias ORDER BY nome";


$resultado_categorias = mysqli_query($conexao, $sql);

?>
