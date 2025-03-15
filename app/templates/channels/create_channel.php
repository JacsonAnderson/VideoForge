<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../app/db.php';

// Função para gerar um ID único
function generateChannelId() {
    return strtoupper(bin2hex(random_bytes(8)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name           = isset($_POST['channelName']) ? trim($_POST['channelName']) : '';
    $language       = isset($_POST['channelLanguage']) ? trim($_POST['channelLanguage']) : '';
    $minPromptChars = isset($_POST['minPromptChars']) ? (int)$_POST['minPromptChars'] : null;
    $prompt         = isset($_POST['channelPrompt']) ? trim($_POST['channelPrompt']) : '';
    $voiceModel     = isset($_POST['voiceModel']) ? trim($_POST['voiceModel']) : null;
    $watermark      = isset($_POST['watermark']) ? trim($_POST['watermark']) : null;
    $music          = isset($_POST['music']) ? trim($_POST['music']) : null;

    // Verificação de campos obrigatórios
    if (empty($name) || empty($language) || empty($prompt)) {
        echo json_encode(['status' => 'error', 'message' => 'Por favor, preencha os campos obrigatórios.']);
        exit;
    }

    try {
        // Verificar se o canal com o mesmo nome já existe
        $checkSql = "SELECT id FROM channels WHERE name = :name LIMIT 1";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([':name' => $name]);
        
        if ($checkStmt->fetch()) {
            echo json_encode(['status' => 'error', 'message' => 'Este canal já existe.']);
            exit;
        }

        // Gerar ID e inserir o novo canal
        $id = generateChannelId();

        $sql = "INSERT INTO channels (id, name, language, min_prompt_chars, prompt, voice_model, watermark, music)
                VALUES (:id, :name, :language, :min_prompt_chars, :prompt, :voice_model, :watermark, :music)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':id'               => $id,
            ':name'             => $name,
            ':language'         => $language,
            ':min_prompt_chars' => $minPromptChars,
            ':prompt'           => $prompt,
            ':voice_model'      => $voiceModel,
            ':watermark'        => $watermark,
            ':music'            => $music,
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Canal criado com sucesso!']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao criar o canal: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método inválido.']);
}
