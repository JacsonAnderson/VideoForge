<?php
// app/templates/channels/create_channel.php

require_once __DIR__ . '/../../app/db.php'; 

// Função para gerar um ID único de 16 caracteres (hexadecimal em letras maiúsculas)
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

    if (empty($name) || empty($language) || empty($prompt)) {
        echo "Por favor, preencha os campos obrigatórios.";
        exit;
    }

    $id = generateChannelId();

    $sql = "INSERT INTO channels (id, name, language, min_prompt_chars, prompt, voice_model, watermark, music)
            VALUES (:id, :name, :language, :min_prompt_chars, :prompt, :voice_model, :watermark, :music)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':id'              => $id,
            ':name'            => $name,
            ':language'        => $language,
            ':min_prompt_chars'=> $minPromptChars,
            ':prompt'          => $prompt,
            ':voice_model'     => $voiceModel,
            ':watermark'       => $watermark,
            ':music'           => $music,
        ]);
        echo "Canal criado com sucesso!";
        // Opcional: redirecionar
        // header("Location: content_dashboard.php");
        // exit;
    } catch (PDOException $e) {
        echo "Erro ao criar o canal: " . $e->getMessage();
    }
} else {
    echo "Método inválido.";
}
