<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../app/db.php';

try {
    // Incluindo o ID para ser usado na exclusão
    $stmt = $pdo->query("SELECT id, name, language FROM channels ORDER BY name ASC");
    $channels = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $channels]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao buscar canais: ' . $e->getMessage()]);
}
?>
