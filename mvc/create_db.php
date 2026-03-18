<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1', 'root', '');
    $pdo->exec('CREATE DATABASE IF NOT EXISTS todo_native');
    echo 'Database created successfully';
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
