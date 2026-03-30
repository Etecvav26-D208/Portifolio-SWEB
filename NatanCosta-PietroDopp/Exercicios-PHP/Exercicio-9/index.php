<!--
Data: 26/03/2026
Autor: Pietro Fiorese
Objetivo: Mostrar a media aritmetica de 5 numeros que o usuario digitou

Exercício 9 - Média Aritmética com Função
Crie uma função:

function media($v)

Que receba uma lista de números reais e retorne a média aritmética.
-->
<!DOCTYPE html>
<html>
<head>
    <title>Média dos Números</title>
</head>
<body>

<h1>Digite 5 números reais</h1>

<form action="calcula.php" method="GET">
    
    Número 1: <input type="number" step="any" name="n1" required>
    <br><br>
    Número 2: <input type="number" step="any" name="n2" required>
    <br><br>
    Número 3: <input type="number" step="any" name="n3" required>
    <br><br>
    Número 4: <input type="number" step="any" name="n4" required>
    <br><br>
    Número 5: <input type="number" step="any" name="n5"required>
    <br><br>

    <input type="submit" value="Calcular Média">

</form>

</body>
</html>