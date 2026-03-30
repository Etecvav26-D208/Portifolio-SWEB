<!--
Data: 26/03/2026
Autor: Pietro Fiorese
Objetivo: Pegar o ano digitado e dizer se ele é um ano bissexto ou nao

Exercício 10 - Ano Bissexto
Leia um ano e informe se ele é bissexto.

Um ano é bissexto se:

É múltiplo de 400
ou
É múltiplo de 4 e não é múltiplo de 100
-->
<!DOCTYPE html>
<html>
<head>
    <title>Ano Bissexto</title>
</head>
<body>

<h1>Digite um ano</h1>

<form action="calcula.php" method="GET">
    
    Ano: <input type="number" name="ano" required>
    <br><br>
    
    <input type="submit" value="Verificar">

</form>

</body>
</html>