<?php

include("../../conexao.php");

$id = $_GET["id"];

$sql = "DELETE FROM categorias WHERE id_categoria = $id";

mysqli_query($conexao, $sql);

header("Location: listar.php");
exit;

?>
