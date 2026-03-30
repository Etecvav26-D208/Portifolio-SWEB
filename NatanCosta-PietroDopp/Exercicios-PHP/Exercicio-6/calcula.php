<?php

$n = $_GET["n"];

if ($n <= 0) {
    echo "Digite um número válido!";
} else {

    $a = 0;
    $b = 1;

    for ($i = 1; $i <= $n; $i++) {
        echo $a . " ";

        $proximo = $a + $b;
        $a = $b;
        $b = $proximo;
    }

}

?>