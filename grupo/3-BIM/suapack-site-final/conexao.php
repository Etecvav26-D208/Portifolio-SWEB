<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "suapack";

try {
    $conexao = new mysqli($servidor, $usuario, $senha, $banco);
    $conexao->set_charset("utf8mb4");
} catch (mysqli_sql_exception $erro) {
    http_response_code(500);
    exit("Erro na conexão com o banco de dados.");
}
?>
