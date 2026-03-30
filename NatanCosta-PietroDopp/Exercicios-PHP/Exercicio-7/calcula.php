<?php

$positivos = array();
$negativos = array();

for ($i = 1; $i <= 8; $i++) {
    $num = $_GET["n$i"];

    if ($num >= 0) {
        $positivos[] = $num;
    } else {
        $negativos[] = $num;
    }
}

echo "<h2>Números Positivos:</h2>";
foreach ($positivos as $p) {
    echo $p . " ";
}

echo "<br><br>";

echo "<h2>Números Negativos:</h2>";
foreach ($negativos as $n) {
    echo $n . " ";
}

?>