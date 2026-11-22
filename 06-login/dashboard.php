<?php

require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . '/config/seguranca.php';

exigirLogin();

$consulta = $pdo->prepare(
    'SELECT id, nome, email, criado_em
     FROM usuarios
     WHERE id = :id
     LIMIT 1'
);

$consulta->execute([
    ':id' => $_SESSION['usuario_id']
]);

$usuario = $consulta->fetch();

if (!$usuario) {
    $_SESSION = [];
    session_destroy();

    header('Location: index.php');
    exit;
}

$token = gerarToken();

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Painel do usuário | Access</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header class="topbar">
        <a href="dashboard.php" class="brand">ACCESS<span>.</span></a>

        <form action="logout.php" method="POST">
            <input
                type="hidden"
                name="csrf_token"
                value="<?= escapar($token) ?>"
            >

            <button type="submit" class="logout-button">
                Sair da conta ↗
            </button>
        </form>
    </header>

    <main class="dashboard">

        <section class="welcome">

            <p class="eyebrow">ÁREA RESTRITA / PAINEL PRINCIPAL</p>

            <h1>Olá, <?= escapar($usuario['nome']) ?>.</h1>

            <p>
                Você está autenticado e possui acesso ao painel do sistema.
            </p>

        </section>

        <section class="account-section">

            <div class="section-title">
                <div>
                    <p class="eyebrow">INFORMAÇÕES DA CONTA</p>
                    <h2>Seus dados</h2>
                </div>

                <span class="account-status">CONTA ATIVA</span>
            </div>

            <div class="account-data">

                <div class="data-row">
                    <span>Identificação</span>
                    <strong>#<?= escapar((string) $usuario['id']) ?></strong>
                </div>

                <div class="data-row">
                    <span>Nome</span>
                    <strong><?= escapar($usuario['nome']) ?></strong>
                </div>

                <div class="data-row">
                    <span>E-mail</span>
                    <strong><?= escapar($usuario['email']) ?></strong>
                </div>

                <div class="data-row">
                    <span>Cadastro realizado em</span>
                    <strong>
                        <?= date('d/m/Y H:i', strtotime($usuario['criado_em'])) ?>
                    </strong>
                </div>

            </div>

        </section>

        <section class="dashboard-note">

            <span class="note-number">01</span>

            <div>
                <h3>Autenticação concluída</h3>

                <p>
                    Sua sessão está ativa. Para encerrar o acesso,
                    utilize o botão de saída no cabeçalho.
                </p>
            </div>

        </section>

    </main>

    <footer>
        <span>ACCESS · PAINEL DO USUÁRIO</span>
        <span>SESSÃO AUTENTICADA</span>
    </footer>

</body>
</html>
