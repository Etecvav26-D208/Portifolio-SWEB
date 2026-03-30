<!--
Data: 28/03/2026
Autor: Natan Costa
Objetivo: Criar um codigo que pergunte um numero e calcule para converter a temperatura

Exercício 2 - Conversão de Temperatura
Faça um programa que leia um caractere "F" ou "C", indicando se o valor informado está em Fahrenheit ou Celsius.
Depois, o programa deve converter para a outra unidade.

Fórmula: C = 5/9 × (F − 32)
-->
<!DOCTYPE html>
<html>
<head>
    <title>Conversor de Temperatura</title>
</head>
<body>

<h1>Converter a Temperatura</h1>

<form action="calcula.php" method="GET">
    
    Temperatura: <input type="number" name="temp" step="any" required>
    <br><br>
    
    Tipo (F ou C): <input type="text" name="tipo" maxlength="1" required>
    <br><br>
    
    <input type="submit" value="Converter">

</form>

</body>
</html>