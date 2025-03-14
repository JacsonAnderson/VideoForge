<?php
// app/migrations/create_channels_table.php

require_once __DIR__ . '/../db.php';

// Comando SQL para criar a tabela channels, se ela não existir.
$sql = "CREATE TABLE IF NOT EXISTS channels (
    id VARCHAR(16) PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    language VARCHAR(64) NOT NULL,
    min_prompt_chars INT DEFAULT NULL,
    prompt TEXT NOT NULL,
    voice_model VARCHAR(128) DEFAULT NULL,
    watermark VARCHAR(128) DEFAULT NULL,
    music VARCHAR(128) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

try {
    $pdo->exec($sql);
    echo "Tabela 'channels' criada ou já existe.\n";
} catch (PDOException $e) {
    echo "Erro ao criar a tabela: " . $e->getMessage() . "\n";
}
