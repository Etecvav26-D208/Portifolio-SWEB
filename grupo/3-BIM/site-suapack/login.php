
<?php

session_start();

require_once "conexao.php";

$erro = "";

// Se já estiver logado, redireciona
if (isset($_SESSION["usuario_id"])) {

    if ($_SESSION["usuario_tipo"] === "admin") {

        header("Location: admin/index.php");

    } else {

        header("Location: index.php");

    }

    exit;
}

// Processa o login
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if (empty($email) || empty($senha)) {

        $erro = "Preencha o e-mail e a senha.";

    } else {

        $sql = "
            SELECT
                id_usuario,
                nome,
                email,
                senha,
                tipo
            FROM usuarios
            WHERE email = ?
            LIMIT 1
        ";

        $stmt = mysqli_prepare($conexao, $sql);

        if (!$stmt) {

            $erro = "Erro ao preparar o login.";

        } else {

            mysqli_stmt_bind_param(
                $stmt,
                "s",
                $email
            );

            mysqli_stmt_execute($stmt);

            $resultado = mysqli_stmt_get_result($stmt);

            if (
                $resultado &&
                mysqli_num_rows($resultado) === 1
            ) {

                $usuario = mysqli_fetch_assoc($resultado);

                // Confere a senha criptografada
                if (
                    password_verify(
                        $senha,
                        $usuario["senha"]
                    )
                ) {

                    session_regenerate_id(true);

                    $_SESSION["usuario_id"] =
                        $usuario["id_usuario"];

                    $_SESSION["usuario_nome"] =
                        $usuario["nome"];

                    $_SESSION["usuario_email"] =
                        $usuario["email"];

                    $_SESSION["usuario_tipo"] =
                        $usuario["tipo"];

                    // Redirecionamento por tipo
                    if ($usuario["tipo"] === "admin") {

                        header(
                            "Location: admin/index.php"
                        );

                    } else {

                        header(
                            "Location: index.php"
                        );

                    }

                    exit;

                } else {

                    $erro = "E-mail ou senha incorretos.";

                }

            } else {

                $erro = "E-mail ou senha incorretos.";

            }

            mysqli_stmt_close($stmt);

        }

    }

}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login | SUA PACK</title>

    <link rel="stylesheet" href="style.css">

    <style>

        .login-pagina {

            min-height: 80vh;

            display: flex;

            justify-content: center;

            align-items: center;

            padding: 50px 20px;

        }

        .login-container {

            width: 100%;

            max-width: 450px;

            background: #f4f4f4;

            padding: 40px;

            box-sizing: border-box;

        }

        .login-container h1 {

            font-size: 48px;

            line-height: 1;

            margin-top: 0;

            margin-bottom: 15px;

        }

        .login-container p {

            margin-bottom: 30px;

        }

        .login-campo {

            margin-bottom: 20px;

        }

        .login-campo label {

            display: block;

            font-weight: bold;

            margin-bottom: 8px;

        }

        .login-campo input {

            width: 100%;

            padding: 14px;

            border: 1px solid #ccc;

            box-sizing: border-box;

            font-family: inherit;

        }

        .login-botao {

            width: 100%;

            padding: 16px;

            border: none;

            background: #111;

            color: white;

            font-weight: bold;

            cursor: pointer;

        }

        .login-botao:hover {

            background: #333;

        }

        .login-erro {

            background: #ffdede;

            color: #900;

            padding: 12px;

            margin-bottom: 20px;

        }

        .login-links {

            margin-top: 25px;

            text-align: center;

        }

        .login-links a {

            color: #111;

            font-weight: bold;

        }

    </style>

</head>

<body>

    <main class="login-pagina">

        <section class="login-container">

            <h1>ENTRAR.</h1>

            <p>
                Acesse sua conta SUA PACK.
            </p>

            <?php if (!empty($erro)): ?>

                <div class="login-erro">

                    <?= htmlspecialchars($erro) ?>

                </div>

            <?php endif; ?>

            <form method="POST">

                <div class="login-campo">

                    <label for="email">
                        E-mail
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Digite seu e-mail"
                        required
                    >

                </div>

                <div class="login-campo">

                    <label for="senha">
                        Senha
                    </label>

                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        placeholder="Digite sua senha"
                        required
                    >

                </div>

                <button
                    type="submit"
                    class="login-botao"
                >
                    ENTRAR
                </button>

            </form>

            <div class="login-links">

                <p>

                    Ainda não tem uma conta?

                    <a href="cadastro.php">
                        Cadastre-se
                    </a>

                </p>

                <p>

                    <a href="index.php">
                        Voltar para a loja
                    </a>

                </p>

            </div>

        </section>

    </main>

</body>

</html>