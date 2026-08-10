<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Criptografia no PHP</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header>
    <h1>Criptografia no PHP</h1>

    <nav>
        <a href="index.php">Início</a>
        <a href="#metodos">Métodos</a>
        <a href="#teste">Testar</a>
    </nav>
</header>

<main>

    <section class="inicio">
        <h2>Proteção de dados com PHP</h2>

        <p>
            O PHP possui funções que ajudam a proteger informações
            como textos e senhas.
        </p>
    </section>


    <section class="card">
        <h2>O que é criptografia?</h2>

        <p>
            Criptografia é uma forma de proteger informações para
            dificultar o acesso de pessoas não autorizadas.
        </p>

        <p>
            No PHP também existem funções de hash, que transformam
            uma informação em outro valor.
        </p>
    </section>


    <section id="metodos">

        <h2 class="titulo">Métodos utilizados</h2>

        <div class="metodos">

            <div class="card">
                <h3>SHA-256</h3>

                <p>
                    Gera um hash do texto utilizando a função
                    hash() do PHP.
                </p>
            </div>


            <div class="card">
                <h3>Password Hash</h3>

                <p>
                    É utilizado principalmente para proteger
                    senhas de usuários.
                </p>
            </div>


            <div class="card">
                <h3>OpenSSL</h3>

                <p>
                    Permite criptografar uma informação e depois
                    recuperá-la utilizando uma chave.
                </p>
            </div>

        </div>

    </section>


    <section class="card" id="teste">

        <h2>Teste os métodos</h2>

        <p>
            Digite uma palavra ou frase para ver os resultados.
        </p>

        <form action="resultado.php" method="POST">

            <label>Texto:</label>

            <input
                type="text"
                name="texto"
                placeholder="Digite aqui..."
                required
            >

            <button type="submit">
                Gerar resultados
            </button>

        </form>

    </section>


    <section class="card">

        <h2>Hash x Criptografia</h2>

        <h3>Hash</h3>

        <p>
            O hash transforma uma informação e não é feito
            para ser revertido.
        </p>

        <h3>Criptografia</h3>

        <p>
            A criptografia permite recuperar a informação
            utilizando a chave correta.
        </p>

    </section>

</main>


<footer>
    Projeto de Sistemas Web - Criptografia no PHP
</footer>

</body>

</html>
