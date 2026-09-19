
<?php

include("../../conexao.php");

$id = $_GET["id"];

$sql = "DELETE FROM pedidos WHERE id_pedido = $id";

mysqli_query($conexao, $sql);

header("Location: listar.php");
exit;

?>
