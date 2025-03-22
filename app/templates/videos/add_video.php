<?php


// app/templates/videos/add_video.php
header('Content-Type: application/json');
require_once __DIR__ . '/../../db.php';

$start_time = microtime(true);

// Valida se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    logInsertion('', '', 'error', 'Método inválido');
    echo json_encode(['status' => 'error', 'message' => 'Método inválido']);
    exit;
}

$channelId = trim($_POST['channelId'] ?? '');
$referenceLink = trim($_POST['referenceLink'] ?? '');

if (empty($channelId) || empty($referenceLink)) {
    logInsertion('', $channelId, 'error', 'Campos obrigatórios não preenchidos', $_POST);
    echo json_encode(['status' => 'error', 'message' => 'Canal e link são obrigatórios.']);
    exit;
}

try {
    // Buscar nome do canal
    $stmt = $pdo->prepare("SELECT name FROM channels WHERE id = :id");
    $stmt->execute([':id' => $channelId]);
    $channel = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$channel) {
        logInsertion('', $channelId, 'error', 'Canal não encontrado', $_POST);
        echo json_encode(['status' => 'error', 'message' => 'Canal não encontrado.']);
        exit;
    }

    $channelName = $channel['name'];

    // Contar vídeos existentes
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM videos WHERE channel_id = :channel_id");
    $stmt->execute([':channel_id' => $channelId]);
    $videoNumber = (int)$stmt->fetchColumn() + 1;

    $videoNumberPadded = str_pad($videoNumber, 3, "0", STR_PAD_LEFT);
    $videoFolderName = $channelName . '-' . $channelId . '-V' . $videoNumberPadded;
    $directoryPath = '/var/www/app/docker/data/channels/' . $videoFolderName;

    if (!is_dir($directoryPath) && !mkdir($directoryPath, 0777, true)) {
        throw new Exception('Erro ao criar diretório do vídeo.');
    }

    // Inserir no banco
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

    logInsertion($channelName, $channelId, 'success', 'Vídeo adicionado com sucesso!', $_POST, $start_time);
    echo json_encode(['status' => 'success', 'message' => 'Vídeo adicionado com sucesso!']);

} catch (Exception $e) {
    logInsertion($channelName ?? '', $channelId, 'error', $e->getMessage(), $_POST, $start_time);
    echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()]);
}

// Função para registrar logs
function logInsertion($channelName, $channelId, $status, $message, $requestData = [], $startTime = null) {
    global $pdo;
    $execTime = $startTime ? round(microtime(true) - $startTime, 5) : null;
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';

    $stmt = $pdo->prepare("INSERT INTO insertion_logs (
        channel_name, channel_id, status, message, request_data,
        request_method, ip_address, execution_time
    ) VALUES (
        :channel_name, :channel_id, :status, :message, :request_data,
        :request_method, :ip_address, :execution_time
    )");

    $stmt->execute([
        ':channel_name' => $channelName,
        ':channel_id' => $channelId,
        ':status' => $status,
        ':message' => $message,
        ':request_data' => json_encode($requestData),
        ':request_method' => $requestMethod,
        ':ip_address' => $ip,
        ':execution_time' => $execTime,
    ]);
}
?>
