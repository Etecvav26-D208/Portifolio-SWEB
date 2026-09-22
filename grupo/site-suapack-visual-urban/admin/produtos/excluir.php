<?php
require_once "../../includes/auth.php";
exigir_admin();



include("../../conexao.php");


/* Pega o ID do produto */

$id = $_GET["id"];


/* Exclui o produto */

$sql = "DELETE FROM produtos WHERE id_produto = $id";

mysqli_query($conexao, $sql);


/* Volta para a lista */

header("Location: listar.php");

exit;

?>
