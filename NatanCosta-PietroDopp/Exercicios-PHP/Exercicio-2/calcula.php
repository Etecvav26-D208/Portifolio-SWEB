<?php

$temp = $_GET["temp"];
$tipo = $_GET["tipo"];

if ($tipo == "F") {
    $celsius = (5/9) * ($temp - 32);
    echo "Temperatura em Celsius: " . $celsius;
}
elseif ($tipo == "C") {
    $fahrenheit = ($temp * 9/5) + 32;
    echo "Temperatura em Fahrenheit: " . $fahrenheit;
}
else {
    echo "Digite apenas F ou C.";
}

?>