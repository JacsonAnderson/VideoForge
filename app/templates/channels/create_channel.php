<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../app/db.php';

// Verificar se é uma requisição AJAX
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    echo json_encode(['status' => 'error', 'message' => 'Acesso inválido.']);
    exit;
}

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
        $pdo->beginTransaction();

        // Verificar se o canal já existe com bloqueio para evitar race conditions
        $checkSql = "SELECT id FROM channels WHERE BINARY LOWER(name) = LOWER(:name) LIMIT 1 FOR UPDATE";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([':name' => $name]);

        if ($checkStmt->fetch()) {
            $pdo->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Este canal já existe.']);
            exit;
        }

        $id = generateChannelId();

        // Inserir o canal
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

        $pdo->commit();
        echo json_encode(['status' => 'success', 'message' => 'Canal criado com sucesso!']);
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'Erro ao criar o canal: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método inválido.']);
}
?>
