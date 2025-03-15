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

// Função para criar diretório com logs de erro detalhados
function createChannelDirectory($channelName, $channelId) {
    $baseDir = '/var/www/app/docker/data/channels/'; // Caminho absoluto no container
    $directoryName = $channelName . '-' . $channelId;
    $directoryPath = $baseDir . $directoryName;

    // Verifica se o diretório base existe
    if (!is_dir($baseDir)) {
        if (!mkdir($baseDir, 0777, true)) {
            throw new Exception('Falha ao criar o diretório base em: ' . $baseDir);
        }
    }

    // Cria o diretório do canal se não existir
    if (!is_dir($directoryPath)) {
        if (!mkdir($directoryPath, 0777, true)) {
            throw new Exception('Falha ao criar o diretório do canal em: ' . $directoryPath);
        }
    }

    return $directoryPath;
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

        // Verificar se o canal já existe
        $checkSql = "SELECT id FROM channels WHERE BINARY LOWER(name) = LOWER(:name) LIMIT 1 FOR UPDATE";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([':name' => $name]);

        if ($checkStmt->fetch()) {
            $pdo->rollBack();
            echo json_encode(['status' => 'error', 'message' => 'Este canal já existe.']);
            exit;
        }

        $id = generateChannelId();

        // Inserir o canal no banco de dados
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

        // Criar o diretório do canal apenas após sucesso no banco
        createChannelDirectory($name, $id);

        echo json_encode(['status' => 'success', 'message' => 'Canal criado com sucesso!']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'Erro ao criar o canal: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método inválido.']);
}
?>
