<!--
Data: 26/03/2026
Autor: Pietro Fiorese
Objetivo: Fazer um codigo que a partir dos 8 numeros do usuario, dizer quais sao positivos e quais negativo

Exercício 7 - Separar Positivos e Negativos
Leia 8 números inteiros e separe em dois vetores:

-Um vetor com números positivos
-Um vetor com números negativos
-->
<!DOCTYPE html>
<html>
<head>
    <title>Separar Postivo e Negativo</title>
</head>
<body>

<h1>Digite 8 números inteiros</h1>

<form action="calcula.php" method="GET">
    
    <?php
    for ($i = 1; $i <= 8; $i++) {
        echo "Número $i: <input type='number' name='n$i'required>
        <br><br>";
    }
    ?>

    <input type="submit" value="Separar">

</form>

</body>
</html>