<?php
// app/migrations/create_videos_table.php

require_once __DIR__ . '/../db.php';

$sql = "CREATE TABLE IF NOT EXISTS videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    channel_id VARCHAR(16) NOT NULL,
    channel_name VARCHAR(255) NOT NULL,
    video_number INT UNSIGNED NOT NULL, -- Contador por canal
    reference_link VARCHAR(255) NOT NULL,
    original_title VARCHAR(255) NOT NULL,
    corrected_transcript TEXT,
    directory_path VARCHAR(255) NOT NULL,
    translated_title VARCHAR(255),
    title_ideas TEXT,
    script TEXT,
    video_description TEXT,
    tags VARCHAR(255),
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
