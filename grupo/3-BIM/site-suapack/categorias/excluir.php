<?php

include("../../conexao.php");

$id = $_GET["id"];


/* Exclui a categoria */

$sql = "DELETE FROM categorias WHERE id_categoria = $id";

mysqli_query($conexao, $sql);


/* Volta para a lista */

header("Location: listar.php");

exit;

?>
