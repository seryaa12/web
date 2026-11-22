<?php

require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . '/config/seguranca.php';

if (usuarioLogado()) {
    header('Location: dashboard.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!validarToken()) {
        $erro = 'Solicitação inválida. Atualize a página e tente novamente.';

    } else {

        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $senha === '') {
            $erro = 'Informe um e-mail e uma senha válidos.';

        } else {

            $sql = $pdo->prepare(
                'SELECT id, nome, email, senha
                 FROM usuarios
                 WHERE email = :email
                 LIMIT 1'
            );

            $sql->execute([
                ':email' => $email
            ]);

            $usuario = $sql->fetch();

            if ($usuario && password_verify($senha, $usuario['senha'])) {

                session_regenerate_id(true);

                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];

                header('Location: dashboard.php');
                exit;

            } else {
                $erro = 'E-mail ou senha incorretos.';
            }
        }
    }
}

$token = gerarToken();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Entrar | Access</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header class="topbar">
        <a href="index.php" class="brand">ACCESS<span>.</span></a>
        <span class="topbar-label">ÁREA DE AUTENTICAÇÃO</span>
    </header>

    <main class="auth-layout">

        <section class="auth-intro">

            <p class="eyebrow">SISTEMA 06 / PHP + MYSQL</p>

            <h1>Seu espaço.<br>Sua conta.</h1>

            <p class="description">
                Acesse sua área pessoal ou crie uma conta
                para começar a utilizar o sistema.
            </p>

            <div class="access-note">
                <span class="note-number">01</span>
                <p>Autenticação protegida por sessão e senha criptograficamente armazenada.</p>
            </div>

        </section>

        <section class="auth-panel">

            <div class="panel-heading">
                <p class="eyebrow">BEM-VINDO DE VOLTA</p>
                <h2>Fazer login</h2>
                <p>Insira seus dados para continuar.</p>
            </div>

            <?php if ($erro): ?>
                <div class="message error">
                    <?= escapar($erro) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= escapar($token) ?>"
                >

                <div class="field">
                    <label for="email">E-mail</label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="seu@email.com"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="field">
                    <label for="senha">Senha</label>

                    <input
                        type="password"
                        name="senha"
                        id="senha"
                        placeholder="Digite sua senha"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button type="submit" class="primary-button">
                    Entrar na conta <span>→</span>
                </button>

            </form>

            <div class="auth-footer">
                <span>Ainda não possui cadastro?</span>
                <a href="cadastro.php">Criar conta</a>
            </div>

        </section>

    </main>

    <footer>
        <span>ACCESS · SISTEMA DE AUTENTICAÇÃO</span>
        <span>PHP / MYSQL</span>
    </footer>

</body>
</html>
