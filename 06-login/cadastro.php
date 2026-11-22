
<?php

require_once __DIR__ . '/config/conexao.php';
require_once __DIR__ . '/config/seguranca.php';

if (usuarioLogado()) {
    header('Location: dashboard.php');
    exit;
}

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!validarToken()) {
        $erro = 'Solicitação inválida. Atualize a página e tente novamente.';

    } else {

        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $confirmarSenha = $_POST['confirmar_senha'] ?? '';

        if ($nome === '' || mb_strlen($nome) > 100) {
            $erro = 'Informe um nome válido.';

        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
            $erro = 'Informe um endereço de e-mail válido.';

        } elseif (strlen($senha) < 8) {
            $erro = 'A senha precisa ter pelo menos 8 caracteres.';

        } elseif ($senha !== $confirmarSenha) {
            $erro = 'As senhas informadas não são iguais.';

        } else {

            $consulta = $pdo->prepare(
                'SELECT id FROM usuarios WHERE email = :email LIMIT 1'
            );

            $consulta->execute([
                ':email' => $email
            ]);

            if ($consulta->fetch()) {
                $erro = 'Este e-mail já está cadastrado.';

            } else {

                $senhaHash = password_hash(
                    $senha,
                    PASSWORD_DEFAULT
                );

                $inserir = $pdo->prepare(
                    'INSERT INTO usuarios (nome, email, senha)
                     VALUES (:nome, :email, :senha)'
                );

                $inserir->execute([
                    ':nome' => $nome,
                    ':email' => $email,
                    ':senha' => $senhaHash
                ]);

                $sucesso = 'Cadastro realizado com sucesso! Você já pode entrar na sua conta.';
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

    <title>Criar conta | Access</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header class="topbar">
        <a href="index.php" class="brand">ACCESS<span>.</span></a>
        <span class="topbar-label">NOVO CADASTRO</span>
    </header>

    <main class="auth-layout">

        <section class="auth-intro">

            <p class="eyebrow">CRIAÇÃO DE CONTA</p>

            <h1>Comece<br>por aqui.</h1>

            <p class="description">
                Cadastre seus dados para criar seu acesso
                pessoal ao sistema.
            </p>

            <div class="access-note">
                <span class="note-number">02</span>
                <p>Seus dados de acesso serão armazenados no banco de dados com validações de segurança.</p>
            </div>

        </section>

        <section class="auth-panel">

            <div class="panel-heading">
                <p class="eyebrow">PRIMEIRO ACESSO</p>
                <h2>Criar conta</h2>
                <p>Preencha os campos abaixo.</p>
            </div>

            <?php if ($erro): ?>
                <div class="message error">
                    <?= escapar($erro) ?>
                </div>
            <?php endif; ?>

            <?php if ($sucesso): ?>
                <div class="message success">
                    <?= escapar($sucesso) ?>
                    <br>
                    <a href="index.php">Ir para o login</a>
                </div>
            <?php endif; ?>

            <form method="POST" action="cadastro.php">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= escapar($token) ?>"
                >

                <div class="field">
                    <label for="nome">Nome completo</label>

                    <input
                        type="text"
                        name="nome"
                        id="nome"
                        placeholder="Seu nome"
                        maxlength="100"
                        autocomplete="name"
                        required
                    >
                </div>

                <div class="field">
                    <label for="email">E-mail</label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="seu@email.com"
                        maxlength="150"
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
                        placeholder="Mínimo de 8 caracteres"
                        minlength="8"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <div class="field">
                    <label for="confirmar_senha">Confirmar senha</label>

                    <input
                        type="password"
                        name="confirmar_senha"
                        id="confirmar_senha"
                        placeholder="Digite a senha novamente"
                        minlength="8"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <button type="submit" class="primary-button">
                    Finalizar cadastro <span>→</span>
                </button>

            </form>

            <div class="auth-footer">
                <span>Já possui cadastro?</span>
                <a href="index.php">Fazer login</a>
            </div>

        </section>

    </main>

    <footer>
        <span>ACCESS · SISTEMA DE AUTENTICAÇÃO</span>
        <span>PHP / MYSQL</span>
    </footer>

</body>
</html>
