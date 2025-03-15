<?php
// app/templates/partials/list_channels.php

// Caminho relativo: a partir de "app/templates/partials", subir dois níveis para "app/db.php"
require_once __DIR__ . '/../../db.php';

try {
    $stmt = $pdo->query("SELECT id, name, language FROM channels");
    $channels = $stmt->fetchAll();
} catch (PDOException $e) {
    $channels = [];
    $error = $e->getMessage();
}
?>

<div class="channels-list">
  <?php if (!empty($error)): ?>
    <p style="color:red;">Erro: <?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <?php if (count($channels) > 0): ?>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Língua</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($channels as $channel): ?>
          <tr>
            <td><?php echo htmlspecialchars($channel['id']); ?></td>
            <td><?php echo htmlspecialchars($channel['name']); ?></td>
            <td><?php echo htmlspecialchars($channel['language']); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Nenhum canal existente até o momento. Crie seu primeiro canal para começar a usar o VideoForge!</p>
  <?php endif; ?>
</div>
