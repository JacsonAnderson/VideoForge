<?php
// app/migrations/create_video_tags_table.php

require_once __DIR__ . '/../db.php';

$sql = "CREATE TABLE IF NOT EXISTS video_tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    video_id INT NOT NULL,
    tag_id INT NOT NULL,
    status ENUM('pendente', 'em_progresso', 'pronto', 'erro') DEFAULT 'pendente',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

try {
    $pdo->exec($sql);
    echo "Tabela 'video_tags' criada ou já existe.\n";
} catch (PDOException $e) {
    echo "Erro ao criar a tabela: " . $e->getMessage() . "\n";
}
?>
