<?php


function fatorial($n) {
    $fat = 1;

    for ($i = 1; $i <= $n; $i++) {
        $fat *= $i;
    }

    return $fat;
}


$n1 = $_GET["n1"];
$n2 = $_GET["n2"];
$n3 = $_GET["n3"];
$n4 = $_GET["n4"];
$n5 = $_GET["n5"];


$soma = fatorial($n1) + fatorial($n2) + fatorial($n3) + fatorial($n4) + fatorial($n5);

echo "A soma dos fatoriais é: " . $soma;

?>