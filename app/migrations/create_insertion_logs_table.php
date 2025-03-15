<?php
require_once __DIR__ . '/../db.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS insertion_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        channel_name VARCHAR(255) NOT NULL,
        channel_id VARCHAR(16),
        status VARCHAR(50) NOT NULL,
        message TEXT,
        request_data JSON,
        request_method VARCHAR(10),
        ip_address VARCHAR(45),
        execution_time FLOAT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);
    echo "Tabela 'insertion_logs' criada com sucesso.\n";
} catch (PDOException $e) {
    echo "Erro ao criar a tabela 'insertion_logs': " . $e->getMessage() . "\n";
}
?>
