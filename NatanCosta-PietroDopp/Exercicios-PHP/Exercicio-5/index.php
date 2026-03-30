<!--
Data: 28/03/2026
Autor: Natan Costa
Objetivo: Criar um codigo que mostra o soma dos nomeros fatoriais como 5! + 2!

Exercício 5 - Somatório de Fatoriais
Leia 5 números inteiros e mostre a soma dos fatoriais desses números.
-->
<!DOCTYPE html>
<html>
<head>
    <title>Soma dos Fatoriais</title>
</head>
<body>

<h1>Digite 5 números inteiros</h1>

<form action="calcula.php" method="GET">
    
    Número 1: <input type="number" name="n1" required>
    <br><br>
    Número 2: <input type="number" name="n2" required>
    <br><br>
    Número 3: <input type="number" name="n3" required>
    <br><br>
    Número 4: <input type="number" name="n4" required>
    <br><br>
    Número 5: <input type="number" name="n5" required>
    <br><br>

    <input type="submit" value="Calcular">

</form>

</body>
</html>