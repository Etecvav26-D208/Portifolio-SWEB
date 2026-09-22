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
.cadastro-pagina{min-height:80vh;display:flex;justify-content:center;align-items:center;padding:50px 20px}
.cadastro-container{width:100%;max-width:450px;background:#f4f4f4;padding:40px;box-sizing:border-box}
.cadastro-container h1{font-size:48px;line-height:1;margin:0 0 15px}
.cadastro-container>p{margin-bottom:30px}
.cadastro-campo{margin-bottom:20px}
.cadastro-campo label{display:block;font-weight:bold;margin-bottom:8px}
.cadastro-campo input{width:100%;padding:14px;border:1px solid #ccc;box-sizing:border-box;font-family:inherit}
.cadastro-botao{width:100%;padding:16px;border:none;background:#111;color:white;font-weight:bold;cursor:pointer}
.cadastro-botao:hover{background:#333}
.cadastro-erro{background:#ffdede;color:#900;padding:12px;margin-bottom:20px}
.cadastro-links{margin-top:25px;text-align:center}
.cadastro-links a{color:#111;font-weight:bold}
</style>
</head>
<body>
<main class="cadastro-pagina">
<section class="cadastro-container">
<p class="section-small">SUA PACK</p>
<h1>CRIAR CONTA.</h1>
<p>Crie sua conta para comprar e acompanhar seus pedidos.</p>
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
