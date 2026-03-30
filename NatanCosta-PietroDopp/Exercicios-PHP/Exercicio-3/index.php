<!--
Data: 28/03/2026
Autor: Natan Costa
Objetivo: Criar um codigo que monte uma calculadora com as 4 operacoes basicas

Exercício 3 - Calculadora Aritmética
Faça um programa que leia dois números e um operador ("+", "-", "*" ou "/").
O programa deve mostrar o resultado da operação.
-->
<!DOCTYPE html>
<html>
<head>
    <title>Calculadora</title>
</head>
<body>

<h1>A Calculadora</h1>

<form action="calcula.php" method="GET">
    
    Número 1: <input type="number" name="n1" step="any"required>
    <br><br>
    
    Número 2: <input type="number" name="n2" step="any"required>
    <br><br>
    
    Operador (+, -, *, /): 
    <input type="text" name="op" maxlength="1"><br><br>
    
    <input type="submit" value="Calcular">

</form>

</body>
</html>