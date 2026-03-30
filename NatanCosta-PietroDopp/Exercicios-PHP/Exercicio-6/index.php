<!--
Data: 26/03/2026
Autor: Pietro Fiorese
Objetivo: Criar uma sequencia de fibonacci com codigo a partir do numero digitado

Exercício 6 - Série de Fibonacci
Leia um número n e mostre os n primeiros termos da sequência de Fibonacci.

Exemplo:
n = 12
Resultado:
0 1 1 2 3 5 8 13 21 34 55 89
-->
<!DOCTYPE html>
<html>
<head>
    <title>Sequência de Fibonacci</title>
</head>
<body>

<h1>Digite o número desejado</h1>

<form action="calcula.php" method="GET">
    
    Valor para a sequência: <input type="number" name="n" required>
    <br><br>
    
    <input type="submit" value="Gerar">

</form>

</body>
</html>