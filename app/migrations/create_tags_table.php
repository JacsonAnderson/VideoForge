<?php
// app/migrations/create_tags_table.php

require_once __DIR__ . '/../db.php';

$sql = "CREATE TABLE IF NOT EXISTS tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

try {
    $pdo->exec($sql);
    echo "Tabela 'tags' criada ou já existe.\n";
} catch (PDOException $e) {
    echo "Erro ao criar a tabela: " . $e->getMessage() . "\n";
}
?>
