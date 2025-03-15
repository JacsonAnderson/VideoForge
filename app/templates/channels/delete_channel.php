<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../app/db.php';

$data = json_decode(file_get_contents('php://input'), true);

// Verificar se o ID foi fornecido e está limpo
if (!isset($data['id']) || empty(trim($data['id']))) {
    echo json_encode(['status' => 'error', 'message' => 'ID do canal não fornecido ou inválido.']);
    exit;
}

$channelId = trim($data['id']);

try {
    // Verificar se o canal realmente existe
    $checkStmt = $pdo->prepare("SELECT id FROM channels WHERE id = :id");
    $checkStmt->execute([':id' => $channelId]);

    if (!$checkStmt->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'Canal não encontrado.']);
        exit;
    }

    // Deletar o canal
    $stmt = $pdo->prepare("DELETE FROM channels WHERE id = :id");
    $stmt->execute([':id' => $channelId]);

    // Verificar se a linha foi realmente afetada
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Canal excluído com sucesso.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Nenhum canal foi excluído.']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao excluir canal: ' . $e->getMessage()]);
}
?>
