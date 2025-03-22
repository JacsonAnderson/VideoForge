<?php
// add_video.php - Localizado em app/templates/videos/add_video.php

// Ativa exibição de erros para debug (remova ou desative em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once __DIR__ . '/../../app/db.php';

$start_time = microtime(true);

// Validação do método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método inválido']);
    exit;
}

$channelId = trim($_POST['channelId'] ?? '');
$referenceLink = trim($_POST['referenceLink'] ?? '');

if (!$channelId || !$referenceLink) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Canal e link são obrigatórios.']);
    exit;
}

try {
    // Busca o nome do canal
    $stmt = $pdo->prepare("SELECT name FROM channels WHERE id = :id");
    $stmt->execute([':id' => $channelId]);
    $channel = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$channel) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Canal não encontrado.']);
        exit;
    }
    $channelName = $channel['name'];

    // Conta vídeos existentes para o canal
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM videos WHERE channel_id = :channel_id");
    $stmt->execute([':channel_id' => $channelId]);
    $videoNumber = (int)$stmt->fetchColumn() + 1;
    $videoNumberPadded = str_pad($videoNumber, 3, "0", STR_PAD_LEFT);

    // Gera o nome da pasta e caminho
    $videoFolderName = $channelName . '-' . $channelId . '-V' . $videoNumberPadded;
    $directoryPath = '/var/www/app/docker/data/channels/' . $videoFolderName;

    if (!is_dir($directoryPath) && !mkdir($directoryPath, 0777, true)) {
        throw new Exception('Erro ao criar diretório do vídeo.');
    }

    // Insere o vídeo na tabela
    $stmt = $pdo->prepare("INSERT INTO videos (
        channel_id, channel_name, video_number, reference_link,
        original_title, corrected_transcript, directory_path,
        translated_title, title_ideas, script, video_description, tags
    ) VALUES (
        :channel_id, :channel_name, :video_number, :reference_link,
        '', '', :directory_path,
        '', '', '', '', ''
    )");
    $stmt->execute([
        ':channel_id' => $channelId,
        ':channel_name' => $channelName,
        ':video_number' => $videoNumber,
        ':reference_link' => $referenceLink,
        ':directory_path' => $directoryPath,
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Vídeo adicionado com sucesso!']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()]);
}
?>
