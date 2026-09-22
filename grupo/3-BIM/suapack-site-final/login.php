<?php
require_once "includes/auth.php";
require_once "conexao.php";

$erro = "";
$modo = ($_POST["modo"] ?? "cliente") === "admin" ? "admin" : "cliente";
$redirecionar = $_GET["redirect"] ?? "";
$redirecionar = in_array($redirecionar, ["checkout.php", "index.php", "perfil.php"], true) ? $redirecionar : "";

if (usuario_logado()) {
    header("Location: " . (usuario_admin() ? "admin/index.php" : "index.php"));
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = strtolower(trim($_POST["email"] ?? ""));
    $senha = $_POST["senha"] ?? "";

    if ($email === "" || $senha === "") {
        $erro = "Preencha o e-mail e a senha.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Digite um e-mail válido.";
    } else {
        $stmt = $conexao->prepare("SELECT id_usuario, nome, email, senha, tipo FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if (!password_verify($senha, $usuario["senha"])) {
                $erro = "E-mail ou senha incorretos.";
            } elseif ($modo === "admin" && $usuario["tipo"] !== "admin") {
                $erro = "Esta conta não possui acesso de administrador. Escolha ENTRAR COMO CLIENTE.";
            } elseif ($modo === "cliente" && $usuario["tipo"] !== "cliente") {
                $erro = "Esta é uma conta administrativa. Escolha ENTRAR COMO ADMINISTRADOR.";
            } else {
                session_regenerate_id(true);
                $_SESSION["usuario_id"] = (int)$usuario["id_usuario"];
                $_SESSION["usuario_nome"] = $usuario["nome"];
                $_SESSION["usuario_email"] = $usuario["email"];
                $_SESSION["usuario_tipo"] = $usuario["tipo"];

                if ($usuario["tipo"] === "admin") {
                    header("Location: admin/index.php");
                } else {
                    header("Location: " . ($redirecionar !== "" ? $redirecionar : "index.php"));
                }
                exit;
            }
        } else {
            $erro = "E-mail ou senha incorretos.";
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | SUA PACK</title>
<link rel="stylesheet" href="style.css">
<style>
.login-pagina{min-height:100vh;display:flex;justify-content:center;align-items:center;padding:48px 20px;background:#080808}
.login-container{width:100%;max-width:500px;background:#f4f4f2;color:#111;padding:46px 44px 40px;box-sizing:border-box;border:1px solid #242424;box-shadow:0 24px 70px rgba(0,0,0,.32)}
.login-marca{display:block;color:#75b900;font-size:11px;font-weight:900;letter-spacing:6px;margin-bottom:28px}
.login-container h1{color:#111;font-family:Impact,"Arial Black",sans-serif;font-size:clamp(44px,8vw,62px);line-height:.92;letter-spacing:1px;margin:0 0 12px}
.login-subtitulo{color:#666;font-size:14px;line-height:1.6;margin:0 0 26px}
.login-modos{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin:0 0 26px;padding:5px;background:#e7e7e4;border:1px solid #d3d3d0}
.login-modo{border:1px solid transparent;background:transparent;color:#555;min-height:44px;font-size:11px;font-weight:900;letter-spacing:.7px;cursor:pointer;transition:.2s}
.login-modo.ativo{background:#111;color:#fff;border-color:#111;box-shadow:0 4px 12px rgba(0,0,0,.12)}
.login-modo:hover{color:#111}.login-modo.ativo:hover{color:#b7ff00}
.login-campo{margin-bottom:19px}.login-campo label{display:block;color:#181818;font-size:12px;font-weight:800;letter-spacing:.7px;text-transform:uppercase;margin-bottom:8px}
.login-campo input{width:100%;height:50px;padding:0 14px;border:1px solid #c8c8c8;background:#fff;color:#111;outline:none;box-sizing:border-box;font-size:14px;transition:border-color .2s,box-shadow .2s}
.login-campo input::placeholder{color:#8a8a8a}.login-campo input:focus{border-color:#111;box-shadow:0 0 0 2px rgba(182,255,0,.35)}
.login-botao{width:100%;height:52px;border:1px solid #111;background:#111;color:#fff;font-size:12px;font-weight:900;letter-spacing:1.5px;cursor:pointer;transition:.2s}.login-botao:hover{background:#b6ff00;border-color:#b6ff00;color:#000}
.login-erro{background:#fff0f0;border-left:3px solid #b00020;color:#8d0019;padding:12px 14px;margin-bottom:20px;font-size:13px;line-height:1.5}
.login-sucesso{background:#efffd8;border-left:3px solid #77b800;color:#365800;padding:12px 14px;margin-bottom:20px;font-size:13px;line-height:1.5}
.login-links{margin-top:28px;padding-top:22px;border-top:1px solid #d9d9d9;text-align:center}.login-links p{color:#666;font-size:13px;line-height:1.5;margin:0 0 12px}.login-links p:last-child{margin-bottom:0}.login-links a{color:#111;font-weight:800}.login-links a:hover{color:#6fae00;text-decoration:underline}
.login-ajuda{margin:-10px 0 20px;color:#777;font-size:11px;line-height:1.5}.login-ajuda strong{color:#222}
@media(max-width:520px){.login-pagina{padding:24px 14px}.login-container{padding:34px 24px 30px}.login-modos{grid-template-columns:1fr}.login-modo{min-height:42px}}
</style>
</head>
<body>
<main class="login-pagina">
<section class="login-container">
<span class="login-marca">SUA PACK</span>
<h1>ENTRAR.</h1>
<p class="login-subtitulo">Escolha o tipo de acesso e entre na sua conta.</p>

<div class="login-modos">
    <button type="button" class="login-modo <?= $modo === 'admin' ? 'ativo' : '' ?>" data-modo="admin">ENTRAR COMO ADMINISTRADOR</button>
    <button type="button" class="login-modo <?= $modo === 'cliente' ? 'ativo' : '' ?>" data-modo="cliente">ENTRAR COMO CLIENTE</button>
</div>

<?php if ($erro !== ""): ?>
    <div class="login-erro"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<?php if (isset($_GET["cadastro"]) && $_GET["cadastro"] === "sucesso"): ?>
    <div class="login-sucesso">Cadastro realizado com sucesso. Agora entre como cliente.</div>
<?php endif; ?>

<form method="POST" action="">
    <input type="hidden" name="modo" id="modo" value="<?= htmlspecialchars($modo) ?>">

    <div class="login-campo">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="Digite seu e-mail" autocomplete="email" required>
    </div>

    <div class="login-campo">
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="Digite sua senha" autocomplete="current-password" required>
    </div>

    <p class="login-ajuda"><strong>Administrador:</strong> use uma conta cadastrada como admin. <strong>Cliente:</strong> use uma conta comum da loja.</p>

    <button type="submit" class="login-botao">ENTRAR →</button>
</form>

<div class="login-links">
    <p>Ainda não possui conta? <a href="cadastro.php">CADASTRE-SE</a></p>
    <p><a href="index.php">← VOLTAR PARA A LOJA</a></p>
</div>
</section>
</main>
<script>
const botoes = document.querySelectorAll('.login-modo');
const modo = document.getElementById('modo');
botoes.forEach(botao => {
    botao.addEventListener('click', () => {
        modo.value = botao.dataset.modo;
        botoes.forEach(item => item.classList.remove('ativo'));
        botao.classList.add('ativo');
    });
});
</script>
</body>
</html>
