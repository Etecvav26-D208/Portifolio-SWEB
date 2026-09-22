<?php
require_once "includes/auth.php";
require_once "conexao.php";

if (usuario_logado()) {
    header("Location: " . (usuario_admin() ? "admin/index.php" : "index.php"));
    exit;
}

$erro = "";
$sucesso = "";
$nome = trim($_POST["nome"] ?? "");
$email = strtolower(trim($_POST["email"] ?? ""));

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $senha = $_POST["senha"] ?? "";
    $confirmar = $_POST["confirmar_senha"] ?? "";

    if ($nome === "" || $email === "" || $senha === "" || $confirmar === "") {
        $erro = "Preencha todos os campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Digite um e-mail válido.";
    } elseif (mb_strlen($nome) < 3) {
        $erro = "Digite seu nome completo.";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres.";
    } elseif ($senha !== $confirmar) {
        $erro = "As senhas não coincidem.";
    } else {
        $stmt = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $erro = "Este e-mail já está cadastrado.";
        } else {
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $tipo = "cliente";
            $stmt2 = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("ssss", $nome, $email, $hash, $tipo);
            $stmt2->execute();
            $stmt2->close();
            $stmt->close();
            header("Location: login.php?cadastro=sucesso");
            exit;
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
<title>Cadastro | SUA PACK</title>
<link rel="stylesheet" href="style.css">
<style>
.cadastro-pagina{min-height:100vh;display:flex;justify-content:center;align-items:center;padding:48px 20px;background:#080808}
.cadastro-container{width:100%;max-width:470px;background:#f4f4f2;color:#111;padding:46px 44px 40px;box-sizing:border-box;border:1px solid #242424;box-shadow:0 24px 70px rgba(0,0,0,.28)}
.cadastro-marca{display:block;color:#75b900;font-size:11px;font-weight:800;letter-spacing:6px;margin-bottom:30px}
.cadastro-container h1{color:#111;font-family:Impact,"Arial Black",sans-serif;font-size:clamp(42px,8vw,58px);line-height:.95;letter-spacing:1px;margin:0 0 12px}
.cadastro-subtitulo{color:#666;font-size:14px;line-height:1.6;margin:0 0 32px}
.cadastro-campo{margin-bottom:17px}
.cadastro-campo label{display:block;color:#181818;font-size:12px;font-weight:800;letter-spacing:.7px;text-transform:uppercase;margin-bottom:8px}
.cadastro-campo input{width:100%;height:50px;padding:0 14px;border:1px solid #c8c8c8;border-radius:0;background:#fff;color:#111;outline:none;box-sizing:border-box;font-family:Arial,Helvetica,sans-serif;font-size:14px;transition:border-color .2s,box-shadow .2s}
.cadastro-campo input::placeholder{color:#8a8a8a}
.cadastro-campo input:focus{border-color:#111;box-shadow:0 0 0 2px rgba(182,255,0,.35)}
.cadastro-botao{width:100%;height:50px;padding:0 16px;border:1px solid #111;border-radius:0;background:#111;color:#fff;font-size:12px;font-weight:900;letter-spacing:1.5px;cursor:pointer;transition:.2s}
.cadastro-botao:hover{background:#b6ff00;border-color:#b6ff00;color:#000}
.cadastro-erro{background:#fff0f0;border-left:3px solid #b00020;color:#8d0019;padding:12px 14px;margin-bottom:20px;font-size:13px;line-height:1.5}
.cadastro-links{margin-top:28px;padding-top:22px;border-top:1px solid #d9d9d9;text-align:center}
.cadastro-links p{color:#666;font-size:13px;line-height:1.5;margin:0 0 12px}
.cadastro-links p:last-child{margin-bottom:0}
.cadastro-links a{color:#111;font-weight:800}
.cadastro-links a:hover{color:#6fae00;text-decoration:underline}
@media (max-width:520px){.cadastro-pagina{padding:24px 14px}.cadastro-container{padding:34px 24px 30px}}
</style>
</head>
<body>
<main class="cadastro-pagina">
<section class="cadastro-container">
<span class="cadastro-marca">SUA PACK</span>
<h1>CRIAR CONTA.</h1>
<p class="cadastro-subtitulo">Crie sua conta para comprar e acompanhar seus pedidos.</p>
<?php if ($erro !== ""): ?><div class="cadastro-erro"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
<form method="POST" autocomplete="on">
<div class="cadastro-campo"><label for="nome">Nome completo</label><input type="text" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>" required maxlength="120"></div>
<div class="cadastro-campo"><label for="email">E-mail</label><input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required maxlength="180"></div>
<div class="cadastro-campo"><label for="senha">Senha</label><input type="password" id="senha" name="senha" required minlength="6"></div>
<div class="cadastro-campo"><label for="confirmar_senha">Confirmar senha</label><input type="password" id="confirmar_senha" name="confirmar_senha" required minlength="6"></div>
<button type="submit" class="cadastro-botao">CRIAR CONTA</button>
</form>
<div class="cadastro-links"><p>Já tem uma conta? <a href="login.php">Entrar</a></p><p><a href="index.php">Voltar para a loja</a></p></div>
</section>
</main>
</body>
</html>
