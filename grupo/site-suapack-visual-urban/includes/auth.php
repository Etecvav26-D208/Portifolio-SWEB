<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function usuario_logado(): bool {
    return isset($_SESSION["usuario_id"]);
}

function usuario_admin(): bool {
    return usuario_logado() && ($_SESSION["usuario_tipo"] ?? "") === "admin";
}

function id_usuario_logado(): ?int {
    return usuario_logado() ? (int) $_SESSION["usuario_id"] : null;
}

function nome_usuario_logado(): string {
    return (string) ($_SESSION["usuario_nome"] ?? "");
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
?>
