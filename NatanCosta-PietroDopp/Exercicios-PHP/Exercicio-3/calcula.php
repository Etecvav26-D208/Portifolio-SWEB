<?php

$num1 = $_GET["num1"];
$num2 = $_GET["num2"];
$op = $_GET["op"];

if ($op == "+") {
    $resultado = $num1 + $num2;
    echo "Resultado: " . $resultado;
}
elseif ($op == "-") {
    $resultado = $num1 - $num2;
    echo "Resultado: " . $resultado;
}
elseif ($op == "*") {
    $resultado = $num1 * $num2;
    echo "Resultado: " . $resultado;
}
elseif ($op == "/") {
    if ($num2 != 0) {
        $resultado = $num1 / $num2;
        echo "Resultado: " . $resultado;
    } else {
        echo "Erro: divisão por zero!";
    }
}
else {
    echo "Nenhum operador, use +, -, * ou /.";
}

?>