<?php

$texto = $_POST["texto"];

$sha256 = hash("sha256", $texto);

$senha = password_hash($texto, PASSWORD_DEFAULT);

$chave = "minha-chave";

$criptografado = openssl_encrypt(
    $texto,
    "AES-128-ECB",
    $chave
);

$descriptografado = openssl_decrypt(
    $criptografado,
    "AES-128-ECB",
    $chave
);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Resultados</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>

    <h1>Criptografia no PHP</h1>

    <nav>
        <a href="index.php">Início</a>
        <a href="resultado.php">Resultados</a>
    </nav>

</header>


<main>

    <section class="inicio">

        <h2>Resultados</h2>

        <p>
            Veja os resultados gerados pelo PHP.
        </p>

    </section>


    <section class="card">

        <h2>Texto digitado</h2>

        <div class="resultado">
            <?php echo htmlspecialchars($texto); ?>
        </div>

    </section>


    <section class="card">

        <h2>SHA-256</h2>

        <p>
            Resultado utilizando a função hash().
        </p>

        <div class="resultado">
            <?php echo $sha256; ?>
        </div>

    </section>


    <section class="card">

        <h2>Password Hash</h2>

        <p>
            Resultado utilizando password_hash().
        </p>

        <div class="resultado">
            <?php echo $senha; ?>
        </div>

    </section>


    <section class="card">

<h2>Criptografia</h2>

<p>
    Resultado utilizando OpenSSL.
</p>

<div class="resultado">
    <?php echo $criptografado; ?>
</div>

</section>


<section class="card">

<h2>Descriptografia</h2>

<p>
    Utilizando a mesma chave, o texto original pode ser recuperado.
</p>

<div class="resultado">
    <?php echo htmlspecialchars($descriptografado); ?>
</div>

</section>

    <a class="voltar" href="index.php">
        Testar outro texto
    </a>

</main>


<footer>
    Projeto de Sistemas Web - Criptografia no PHP
</footer>

</body>

</html>