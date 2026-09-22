
<?php
require_once "../../includes/auth.php";
exigir_admin();



include("../../conexao.php");

$id = $_GET["id"];


/* Exclui o pedido */

$sql = "DELETE FROM pedidos WHERE id_pedido = $id";

mysqli_query($conexao, $sql);


/* Volta para a lista */

header("Location: listar.php");

exit;

?>
