<?php

function soma($n) {
    $total = 0;

    for ($i = 0; $i <= $n; $i++) {
        $total += $i;
    }

    return $total;
}

$n = $_GET["n"];

if ($n >= 0) {
    echo "A soma de 0 até $n é= " . soma($n);
} else {
    echo "Digite um número inteiro (não negativo).";
}

?>