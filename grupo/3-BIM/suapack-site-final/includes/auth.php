<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

const EMAIL_ADMIN_PRINCIPAL = 'mariaeduardaporodrigues@gmail.com';

function usuario_logado(): bool {
    return isset($_SESSION["usuario_id"]);
}

function usuario_admin(): bool {
    return usuario_logado() && ($_SESSION["usuario_tipo"] ?? "") === "admin";
}

function usuario_admin_principal(): bool {
    return usuario_admin() && strtolower((string)($_SESSION["usuario_email"] ?? "")) === EMAIL_ADMIN_PRINCIPAL;
}

function id_usuario_logado(): ?int {
    return usuario_logado() ? (int) $_SESSION["usuario_id"] : null;
}

function nome_usuario_logado(): string {
    return (string) ($_SESSION["usuario_nome"] ?? "");
}

function email_usuario_logado(): string {
    return (string) ($_SESSION["usuario_email"] ?? "");
}

function exigir_login(string $destino = "login.php"): void {
    if (!usuario_logado()) {
        header("Location: " . $destino);
        exit;
    }
}

function exigir_admin(string $destino = "../login.php"): void {
    if (!usuario_admin()) {
        header("Location: " . $destino);
        exit;
    }
}

function bloquear_admin_na_loja(string $destino = "admin/index.php"): void {
    if (usuario_admin()) {
        header("Location: " . $destino);
        exit;
    }
}
?>
