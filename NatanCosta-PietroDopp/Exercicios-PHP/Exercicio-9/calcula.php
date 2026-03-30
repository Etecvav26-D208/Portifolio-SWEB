<?php

function media($v) {
    $soma = 0;
    $quantidade = count($v);

    foreach ($v as $valor) {
        $soma += $valor;
    }

    return $soma / $quantidade;
}

$valores = array(
    $_GET["n1"],
    $_GET["n2"],
    $_GET["n3"],
    $_GET["n4"],
    $_GET["n5"]
);

echo "A média é: " . media($valores);

?>