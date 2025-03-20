<?php
// app/migrations/create_videos_table.php

require_once __DIR__ . '/../db.php';

$sql = "CREATE TABLE IF NOT EXISTS videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    channel_id VARCHAR(16) NOT NULL,
    name VARCHAR(255) NOT NULL,
    directory_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (channel_id) REFERENCES channels(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

try {
    $pdo->exec($sql);
    echo "Tabela 'videos' criada ou já existe.\n";
} catch (PDOException $e) {
    echo "Erro ao criar a tabela: " . $e->getMessage() . "\n";
}
?>
