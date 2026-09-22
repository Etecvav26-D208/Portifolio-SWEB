
<?php

require_once "includes/auth.php";
require_once "conexao.php";

$erro = "";
$redirecionar = $_GET["redirect"] ?? "";
$redirecionar = in_array($redirecionar, ["checkout.php", "index.php"], true) ? $redirecionar : "";

// Se já estiver logado, redireciona
if (usuario_logado()) {

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
                            "Location: " . ($redirecionar !== "" ? $redirecionar : "index.php")
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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 48px 20px;
            background: #080808;
        }

        .login-container {
            width: 100%;
            max-width: 470px;
            background: #f4f4f2;
            color: #111;
            padding: 46px 44px 40px;
            box-sizing: border-box;
            border: 1px solid #242424;
            box-shadow: 0 24px 70px rgba(0,0,0,.28);
        }

        .login-marca {
            display: block;
            color: #75b900;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 6px;
            margin-bottom: 30px;
        }

        .login-container h1 {
            color: #111;
            font-family: Impact, "Arial Black", sans-serif;
            font-size: clamp(42px, 8vw, 58px);
            line-height: .95;
            letter-spacing: 1px;
            margin: 0 0 12px;
        }

        .login-subtitulo {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin: 0 0 32px;
        }

        .login-campo {
            margin-bottom: 19px;
        }

        .login-campo label {
            display: block;
            color: #181818;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .7px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .login-campo input {
            width: 100%;
            height: 50px;
            padding: 0 14px;
            border: 1px solid #c8c8c8;
            border-radius: 0;
            background: #fff;
            color: #111;
            outline: none;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            transition: border-color .2s, box-shadow .2s;
        }

        .login-campo input::placeholder {
            color: #8a8a8a;
        }

        .login-campo input:focus {
            border-color: #111;
            box-shadow: 0 0 0 2px rgba(182,255,0,.35);
        }

        .login-botao {
            width: 100%;
            height: 50px;
            padding: 0 16px;
            border: 1px solid #111;
            border-radius: 0;
            background: #111;
            color: #fff;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: .2s;
        }

        .login-botao:hover {
            background: #b6ff00;
            border-color: #b6ff00;
            color: #000;
        }

        .login-erro {
            background: #fff0f0;
            border-left: 3px solid #b00020;
            color: #8d0019;
            padding: 12px 14px;
            margin-bottom: 20px;
            font-size: 13px;
            line-height: 1.5;
        }

        .login-links {
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid #d9d9d9;
            text-align: center;
        }

        .login-links p {
            color: #666;
            font-size: 13px;
            line-height: 1.5;
            margin: 0 0 12px;
        }

        .login-links p:last-child {
            margin-bottom: 0;
        }

        .login-links a {
            color: #111;
            font-weight: 800;
        }

        .login-links a:hover {
            color: #6fae00;
            text-decoration: underline;
        }

        @media (max-width: 520px) {
            .login-pagina {
                padding: 24px 14px;
            }

            .login-container {
                padding: 34px 24px 30px;
            }
        }
    </style>

</head>

<body>

    <main class="login-pagina">

        <section class="login-container">

            <span class="login-marca">SUA PACK</span>

            <h1>ENTRAR.</h1>

            <p class="login-subtitulo">
                Acesse sua conta e continue sua compra.
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