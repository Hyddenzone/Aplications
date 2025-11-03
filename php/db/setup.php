<?php
try {
    $pdo = new PDO('sqlite:db/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE TABLE IF NOT EXISTS links (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        url TEXT NOT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL,
        password TEXT NOT NULL
    )");

    $pdo->exec("INSERT INTO users (username, password) VALUES ('admin', 'admin')");

    echo "Banco criado com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
