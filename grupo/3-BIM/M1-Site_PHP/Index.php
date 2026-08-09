<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Criptografia no PHP</title>

    <link rel="stylesheet" href="css/style.css">
</head>
    
<body>

    <header>

        <h1>Criptografia no PHP</h1>

        <p>
            Conheça alguns métodos utilizados para proteger informações
            em aplicações web.
        </p>

    </header>


    <main class="container">

        <section class="card introducao">

            <h2>🔐 O que é criptografia?</h2>

            <p>
                A criptografia é uma técnica utilizada para proteger informações,
                transformando os dados para dificultar o acesso de pessoas não autorizadas.
            </p>

            <p>
                No PHP existem diferentes recursos que podem ser utilizados
                para proteger textos, senhas e outras informações.
            </p>

        </section>


        <section class="card">

            <h2>Digite um texto</h2>

            <p class="descricao">
                Insira uma palavra ou frase para visualizar os métodos disponíveis.
            </p>

            <form method="POST">

                <label for="texto">
                    Texto:
                </label>
    <input
                    type="text"
                    id="texto"
                    name="texto"
                    placeholder="Digite uma palavra ou frase..."
                    required
                >

                <button type="submit">
                    Gerar resultados
                </button>

            </form>

        </section>


        <section class="resultados">

            <h2 class="titulo-resultados">
                Resultados
            </h2>


            <div class="card resultado-card">

                <div class="icone">
                    #
                </div>

                <div class="conteudo">

                    <h3>Hash SHA-256</h3>

                    <p>
                        Transforma o texto em uma sequência de caracteres
                        de tamanho fixo.
                    </p>

                    <div class="resultado">

                        <!-- A outra dupla coloca o resultado PHP aqui -->

                        O resultado aparecerá aqui.

                    </div>

                </div>

            </div>


            <div class="card resultado-card">

                <div class="icone">
                    🔑
                </div>

                <div class="conteudo">

                    <h3>Hash de Senha</h3>

                    <p>
                        O password_hash é utilizado para proteger
                        senhas de usuários.
                    </p>

                    <div class="resultado">

                        <!-- A outra dupla coloca o resultado PHP aqui -->

                        O resultado aparecerá aqui.

                    </div>

                </div>

            </div>


            <div class="card resultado-card">

                <div class="icone">
                    🔒
                </div>

                <div class="conteudo">

                    <h3>Criptografia</h3>

                    <p>
                        Diferente do hash, a criptografia permite proteger
                        um dado e recuperá-lo posteriormente utilizando
                        uma chave.
                    </p>

                    <div class="resultado">

                        <!-- A outra dupla coloca o resultado PHP aqui -->

                        O resultado aparecerá aqui.

                    </div>

                </div>

            </div>

        </section>


        <section class="card diferenca">

            <h2>Hash x Criptografia</h2>

            <div class="comparacao">

                <div>

                    <h3>Hash</h3>

                    <p>
                        Transforma a informação e não foi feito
                        para ser revertido.
                    </p>

                </div>


                <div>
            
