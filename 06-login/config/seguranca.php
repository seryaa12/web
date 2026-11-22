<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function usuarioLogado(): bool
{
    return isset($_SESSION['usuario_id']);
}

function exigirLogin(): void
{
    if (!usuarioLogado()) {
        header('Location: index.php');
        exit;
    }
}

function gerarToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function validarToken(): bool
{
    return isset($_POST['csrf_token'], $_SESSION['csrf_token'])
        && hash_equals(
            $_SESSION['csrf_token'],
            $_POST['csrf_token']
        );
}

function escapar(string $valor): string
{
    return htmlspecialchars(
        $valor,
        ENT_QUOTES,
        'UTF-8'
    );
}
