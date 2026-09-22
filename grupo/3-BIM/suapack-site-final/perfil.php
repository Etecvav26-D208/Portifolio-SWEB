<?php
require_once "includes/auth.php";
require_once "conexao.php";

exigir_login("login.php?redirect=perfil.php");

$mensagem = "";
$erro = "";

// Somente a conta administrativa principal pode criar e excluir outros administradores.
if (usuario_admin_principal() && $_SERVER["REQUEST_METHOD"] === "POST") {
    $acao = $_POST["acao"] ?? "";

    if ($acao === "criar_admin") {
        $nome = trim($_POST["nome"] ?? "");
        $email = strtolower(trim($_POST["email"] ?? ""));
        $senha = $_POST["senha"] ?? "";
        $confirmar = $_POST["confirmar_senha"] ?? "";

        if ($nome === "" || $email === "" || $senha === "" || $confirmar === "") {
            $erro = "Preencha todos os campos do novo administrador.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro = "Digite um e-mail válido para o administrador.";
        } elseif (strlen($senha) < 6) {
            $erro = "A senha do administrador deve ter pelo menos 6 caracteres.";
        } elseif ($senha !== $confirmar) {
            $erro = "As senhas do administrador não coincidem.";
        } else {
            $stmt = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                $erro = "Este e-mail já está cadastrado.";
            } else {
                $hash = password_hash($senha, PASSWORD_DEFAULT);
                $tipo = "admin";
                $stmt2 = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
                $stmt2->bind_param("ssss", $nome, $email, $hash, $tipo);
                $stmt2->execute();
                $stmt2->close();
                $mensagem = "Administrador criado com sucesso.";
            }
            $stmt->close();
        }
    }

    if ($acao === "excluir_admin") {
        $id_admin = (int)($_POST["id_admin"] ?? 0);

        $stmt = $conexao->prepare("SELECT id_usuario, email, tipo FROM usuarios WHERE id_usuario = ? LIMIT 1");
        $stmt->bind_param("i", $id_admin);
        $stmt->execute();
        $admin = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$admin || $admin["tipo"] !== "admin") {
            $erro = "Administrador não encontrado.";
        } elseif (strtolower($admin["email"]) === EMAIL_ADMIN_PRINCIPAL) {
            $erro = "A conta principal da SUA PACK não pode ser excluída.";
        } else {
            try {
                $stmt = $conexao->prepare("DELETE FROM usuarios WHERE id_usuario = ? AND tipo = 'admin'");
                $stmt->bind_param("i", $id_admin);
                $stmt->execute();
                $stmt->close();
                $mensagem = "Administrador removido com sucesso.";
            } catch (Throwable $e) {
                $erro = "Não foi possível remover este administrador. Verifique se existem pedidos vinculados a essa conta.";
            }
        }
    }
}

$id_usuario = id_usuario_logado();
$stmt = $conexao->prepare("SELECT id_usuario, nome, email, tipo, criado_em FROM usuarios WHERE id_usuario = ? LIMIT 1");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt = $conexao->prepare("SELECT id_pedido, nome_cliente, forma_pagamento, valor_total, status_pedido FROM pedidos WHERE id_usuario = ? ORDER BY id_pedido DESC");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$pedidos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$admins = [];
if (usuario_admin_principal()) {
    $resultado = $conexao->query("SELECT id_usuario, nome, email, criado_em FROM usuarios WHERE tipo = 'admin' ORDER BY id_usuario ASC");
    $admins = $resultado ? $resultado->fetch_all(MYSQLI_ASSOC) : [];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Meu perfil | SUA PACK</title>
<link rel="stylesheet" href="style.css">
<style>
.perfil-pagina{min-height:100vh;background:#080808;color:#fff;padding:70px 5% 100px}.perfil-wrap{max-width:1180px;margin:0 auto}.perfil-topo{display:flex;justify-content:space-between;align-items:flex-end;gap:30px;margin-bottom:42px}.perfil-marca{color:#b7ff00;font-size:11px;font-weight:900;letter-spacing:3px}.perfil-topo h1{font-family:Impact,"Arial Black",sans-serif;font-size:clamp(50px,8vw,86px);line-height:.86;margin:10px 0 0;letter-spacing:-2px}.perfil-topo p{color:#999;max-width:450px;line-height:1.6;font-size:13px}.perfil-acoes{display:flex;gap:10px;flex-wrap:wrap}.perfil-acoes a{display:inline-flex;align-items:center;justify-content:center;min-height:44px;padding:0 18px;border:1px solid #333;color:#fff;text-decoration:none;font-size:11px;font-weight:900;letter-spacing:1px}.perfil-acoes a:hover{border-color:#b7ff00;color:#b7ff00}.perfil-grid{display:grid;grid-template-columns:360px 1fr;gap:20px}.perfil-card{background:#121212;border:1px solid #292929;padding:28px}.perfil-card h2{font-size:18px;margin:0 0 20px;letter-spacing:.5px}.perfil-dado{padding:14px 0;border-bottom:1px solid #252525}.perfil-dado:last-child{border-bottom:0}.perfil-dado span{display:block;color:#777;font-size:10px;font-weight:800;letter-spacing:1.5px;margin-bottom:6px}.perfil-dado strong{font-size:14px;color:#fff;word-break:break-word}.perfil-tag{display:inline-flex;padding:5px 9px;background:#b7ff00;color:#111;font-size:10px;font-weight:900;letter-spacing:1px;text-transform:uppercase}.historico{grid-column:2}.pedido-item{display:grid;grid-template-columns:90px 1fr auto;gap:18px;align-items:center;padding:18px 0;border-bottom:1px solid #282828}.pedido-item:last-child{border-bottom:0}.pedido-numero{color:#b7ff00;font-weight:900}.pedido-info strong{display:block;font-size:14px}.pedido-info span{display:block;color:#888;font-size:11px;margin-top:5px}.pedido-valor{text-align:right;font-weight:900}.pedido-status{display:inline-flex;margin-top:5px;padding:4px 8px;background:#202020;color:#b7ff00;font-size:9px;font-weight:900;letter-spacing:1px;text-transform:uppercase}.sem-pedidos{padding:28px 0;color:#888;font-size:13px}.admin-gestao{margin-top:20px;grid-column:1 / -1;background:linear-gradient(145deg,#151515,#101010);border:1px solid #333;padding:30px}.admin-gestao h2{font-size:22px;margin:0 0 7px}.admin-gestao>p{color:#888;font-size:12px;margin:0 0 24px}.admin-form{display:grid;grid-template-columns:1.1fr 1.2fr 1fr 1fr auto;gap:10px;align-items:end}.admin-form label{display:block;color:#888;font-size:9px;font-weight:900;letter-spacing:1px;margin-bottom:7px}.admin-form input{width:100%;height:46px;background:#0a0a0a;border:1px solid #333;color:#fff;padding:0 12px;box-sizing:border-box;outline:none}.admin-form input:focus{border-color:#b7ff00}.admin-form button{height:46px;padding:0 18px;background:#b7ff00;color:#111;border:1px solid #b7ff00;font-weight:900;font-size:10px;letter-spacing:1px;cursor:pointer}.admin-form button:hover{background:#fff;border-color:#fff}.admin-lista{margin-top:28px;border-top:1px solid #292929}.admin-linha{display:grid;grid-template-columns:1.2fr 1.4fr 160px auto;gap:15px;align-items:center;padding:15px 0;border-bottom:1px solid #222}.admin-linha strong{font-size:13px}.admin-linha span{color:#888;font-size:11px}.admin-linha form{margin:0}.admin-excluir{background:transparent;border:1px solid #4b2222;color:#ff7b7b;padding:8px 10px;font-size:9px;font-weight:900;letter-spacing:1px;cursor:pointer}.admin-excluir:hover{background:#4b2222;color:#fff}.perfil-alerta{padding:12px 14px;margin-bottom:18px;font-size:12px}.perfil-alerta.sucesso{background:#efffd8;color:#365800;border-left:3px solid #b7ff00}.perfil-alerta.erro{background:#fff0f0;color:#8d0019;border-left:3px solid #b00020}.voltar-perfil{display:inline-block;color:#fff;text-decoration:none;font-size:12px;margin-bottom:25px}.voltar-perfil:hover{color:#b7ff00}@media(max-width:900px){.perfil-grid{grid-template-columns:1fr}.historico,.admin-gestao{grid-column:auto}.admin-form{grid-template-columns:1fr 1fr}.admin-form button{grid-column:1/-1}.admin-linha{grid-template-columns:1fr 1fr}.admin-linha form{grid-column:1/-1}}@media(max-width:600px){.perfil-pagina{padding:40px 18px 70px}.perfil-topo{display:block}.perfil-topo p{margin-top:20px}.perfil-acoes{margin-top:25px}.perfil-card,.admin-gestao{padding:20px}.pedido-item{grid-template-columns:70px 1fr}.pedido-valor{grid-column:2;text-align:left}.admin-form{grid-template-columns:1fr}.admin-form button{grid-column:auto}.admin-linha{grid-template-columns:1fr}}
</style>
</head>
<body>
<main class="perfil-pagina">
<div class="perfil-wrap">
<a href="<?= usuario_admin() ? 'admin/index.php' : 'index.php' ?>" class="voltar-perfil">← VOLTAR</a>

<?php if ($mensagem !== ""): ?><div class="perfil-alerta sucesso"><?= htmlspecialchars($mensagem) ?></div><?php endif; ?>
<?php if ($erro !== ""): ?><div class="perfil-alerta erro"><?= htmlspecialchars($erro) ?></div><?php endif; ?>

<header class="perfil-topo">
<div><span class="perfil-marca">SUA PACK / CONTA</span><h1>MEU PERFIL.</h1></div>
<div><p>Consulte seus dados, acompanhe o histórico dos seus pedidos e saia da conta quando quiser.</p><div class="perfil-acoes"><a href="logout.php">SAIR DA CONTA →</a><?php if (!usuario_admin()): ?><a href="produtos.php">CONTINUAR COMPRANDO</a><?php endif; ?></div></div>
</header>

<section class="perfil-grid">
<div class="perfil-card">
<h2>DADOS DA CONTA</h2>
<div class="perfil-dado"><span>NOME</span><strong><?= htmlspecialchars($usuario['nome']) ?></strong></div>
<div class="perfil-dado"><span>E-MAIL</span><strong><?= htmlspecialchars($usuario['email']) ?></strong></div>
<div class="perfil-dado"><span>TIPO DE CONTA</span><strong><span class="perfil-tag"><?= $usuario['tipo'] === 'admin' ? 'Administrador' : 'Cliente' ?></span></strong></div>
<div class="perfil-dado"><span>CONTA CRIADA EM</span><strong><?= date('d/m/Y', strtotime($usuario['criado_em'])) ?></strong></div>
</div>

<div class="perfil-card historico">
<h2>HISTÓRICO DE PEDIDOS</h2>
<?php if (!$pedidos): ?>
    <div class="sem-pedidos">Você ainda não realizou nenhum pedido nesta conta.</div>
<?php else: ?>
    <?php foreach ($pedidos as $pedido): ?>
    <div class="pedido-item">
        <div class="pedido-numero">#<?= (int)$pedido['id_pedido'] ?></div>
        <div class="pedido-info"><strong><?= htmlspecialchars($pedido['nome_cliente']) ?></strong><span><?= htmlspecialchars($pedido['forma_pagamento']) ?> · <span class="pedido-status"><?= htmlspecialchars($pedido['status_pedido']) ?></span></span></div>
        <div class="pedido-valor">R$ <?= number_format((float)$pedido['valor_total'],2,',','.') ?><br><a href="pedido_confirmado.php?id=<?= (int)$pedido['id_pedido'] ?>" style="color:#fff;font-size:9px;letter-spacing:1px;text-decoration:none">VER PEDIDO →</a></div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>

<?php if (usuario_admin_principal()): ?>
<section class="admin-gestao">
<h2>ADMINISTRADORES</h2>
<p>A conta principal pode criar outras contas administrativas. Elas entrarão somente no painel de gerenciamento.</p>

<form method="POST" class="admin-form">
<input type="hidden" name="acao" value="criar_admin">
<div><label>NOME</label><input type="text" name="nome" placeholder="Nome do administrador" required></div>
<div><label>E-MAIL</label><input type="email" name="email" placeholder="admin@exemplo.com" required></div>
<div><label>SENHA</label><input type="password" name="senha" placeholder="Mínimo 6 caracteres" required></div>
<div><label>CONFIRMAR SENHA</label><input type="password" name="confirmar_senha" placeholder="Repita a senha" required></div>
<button type="submit">+ CRIAR ADMIN</button>
</form>

<div class="admin-lista">
<?php foreach ($admins as $admin): ?>
<div class="admin-linha">
<div><strong><?= htmlspecialchars($admin['nome']) ?></strong></div>
<div><span><?= htmlspecialchars($admin['email']) ?></span></div>
<div><span><?= strtolower($admin['email']) === EMAIL_ADMIN_PRINCIPAL ? 'CONTA PRINCIPAL' : 'ADMINISTRADOR' ?></span></div>
<div><?php if (strtolower($admin['email']) !== EMAIL_ADMIN_PRINCIPAL): ?><form method="POST" onsubmit="return confirm('Remover este administrador?');"><input type="hidden" name="acao" value="excluir_admin"><input type="hidden" name="id_admin" value="<?= (int)$admin['id_usuario'] ?>"><button class="admin-excluir" type="submit">REMOVER</button></form><?php endif; ?></div>
</div>
<?php endforeach; ?>
</div>
</section>
<?php endif; ?>
</section>
</div>
</main>
</body>
</html>
