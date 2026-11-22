<?php

$host = 'localhost';
$banco = 'login';
$usuario = 'root';
$senha = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

}  catch (PDOException $erro) {

    http_response_code(500);

    echo '<h2>Erro na conexão com o MySQL</h2>';
    echo '<pre>';
    echo htmlspecialchars($erro->getMessage());
    echo '</pre>';
}