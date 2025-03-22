<?php
require_once __DIR__ . '/../../app/db.php';

try {
    $stmt = $pdo->query("SELECT id, name FROM channels ORDER BY name ASC");
    $canais = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $canais = [];
}
?>

<?php if (count($canais) === 0): ?>
  <div class="no-channels-message">
    <h3>Nenhum canal encontrado ainda.</h3>
    <p>Você pode criar seu primeiro canal clicando em "Gerenciar Canais".</p>
    <p class="tutorial-hint">💡 Em breve, um tutorial visual estará disponível aqui para te guiar.</p>
  </div>

  <style>
    .no-channels-message {
      background: #1f1f1f;
      border: 1px dashed #8B32F4;
      padding: 30px;
      text-align: center;
      margin: 30px;
      border-radius: 8px;
      color: #ccc;
    }
    .no-channels-message h3 {
      color: #fff;
    }
    .tutorial-hint {
      margin-top: 10px;
      font-size: 0.95em;
      color: #8B32F4;
    }
  </style>

<?php else: ?>
  <div class="channel-list-container">
    <?php foreach ($canais as $canal): ?>
      <div class="channel-block">
        <div class="channel-header" onclick="toggleVideos('<?php echo $canal['id']; ?>')">
          <span class="channel-name"><?php echo htmlspecialchars($canal['name']); ?></span>
          <span class="toggle-arrow" id="arrow-<?php echo $canal['id']; ?>">▶</span>
        </div>
        <div class="video-list" id="videos-<?php echo $canal['id']; ?>" style="display: none;">
          <?php
            $stmtVideos = $pdo->prepare("SELECT id, reference_link, video_number FROM videos WHERE channel_id = :channel_id ORDER BY video_number ASC");
            $stmtVideos->execute([':channel_id' => $canal['id']]);
            $videos = $stmtVideos->fetchAll(PDO::FETCH_ASSOC);

            if (count($videos) > 0):
              foreach ($videos as $video):
          ?>
                <div class="video-item">
                  <span>🎬 Vídeo <?php echo str_pad($video['video_number'], 3, "0", STR_PAD_LEFT); ?></span>
                  <a href="<?php echo htmlspecialchars($video['reference_link']); ?>" target="_blank">[Link]</a>
                </div>
          <?php
              endforeach;
            else:
              echo '<div class="video-placeholder">📹 Nenhum vídeo encontrado neste canal ainda.</div>';
            endif;
          ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <style>
    .channel-list-container {
      margin: 20px;
    }
    .channel-block {
      background: #2a2a2a;
      border: 1px solid #3f3f3f;
      border-radius: 8px;
      margin-bottom: 15px;
      overflow: hidden;
    }
    .channel-header {
      padding: 15px 20px;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 1.2em;
      font-weight: bold;
      background: #1e1e1e;
      color: #F3F3F3;
    }
    .toggle-arrow {
      font-size: 1.2em;
      transition: transform 0.3s;
      color: #8B32F4;
    }
    .video-list {
      padding: 15px 30px;
      background: #292929;
    }
    .video-placeholder {
      color: #ccc;
      font-style: italic;
    }
    .video-item {
      margin-bottom: 10px;
      padding: 10px;
      background: #1e1e1e;
      border-radius: 6px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.95em;
      color: #F3F3F3;
    }
    .video-item a {
      color: #8B32F4;
      text-decoration: none;
    }
    .video-item a:hover {
      text-decoration: underline;
    }
  </style>

  <script>
    function toggleVideos(channelId) {
      const list = document.getElementById('videos-' + channelId);
      const arrow = document.getElementById('arrow-' + channelId);
      const isVisible = list.style.display === 'block';

      list.style.display = isVisible ? 'none' : 'block';
      arrow.textContent = isVisible ? '▶' : '▼';
    }
  </script>
<?php endif; ?>
