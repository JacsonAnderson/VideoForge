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
      margin: 30px auto;
      max-width: 700px;
      border-radius: 10px;
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
       <div class="channel-header" data-id="<?php echo $canal['id']; ?>">
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
      display: flex;
      flex-direction: column;
      gap: 20px;
      align-items: center;
      padding: 20px;
    }

    .channel-block {
      background: transparent;
      width: 100%;
      max-width: 800px;
      border-radius: 12px;
      transition: all 0.3s ease;
    }

    .channel-header {
      background: linear-gradient(90deg, #262626, #1f1f1f);
      padding: 12px 18px;
      border: 1px solid #3f3f3f;
      border-radius: 8px;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 1em;
      font-weight: 500;
      color: #F3F3F3;
      transition: background 0.3s, box-shadow 0.3s, transform 0.2s;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .channel-header:hover {
      background: linear-gradient(90deg, #2a2a2a, #1e1e1e);
      transform: scale(1.02);
      box-shadow: 0 4px 12px rgba(139, 50, 244, 0.2);
    }

    .channel-name {
      font-weight: 600;
      font-size: 1.05em;
    }

    .toggle-arrow {
      font-size: 1.1em;
      transition: transform 0.3s ease;
      color: #8B32F4;
    }

    /* Girar seta ao expandir */
    .channel-header.open .toggle-arrow {
      transform: rotate(90deg);
    }

    .video-list {
      padding: 15px 25px;
      background: #2a2a2a;
      margin-top: 10px;
      border-radius: 10px;
    }

    .video-item {
      margin-bottom: 10px;
      padding: 10px 15px;
      background: #1e1e1e;
      border-radius: 8px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #F3F3F3;
      font-size: 0.95em;
    }

    .video-item a {
      color: #8B32F4;
      text-decoration: none;
    }

    .video-item a:hover {
      text-decoration: underline;
    }

    .video-placeholder {
      font-style: italic;
      color: #aaa;
      padding: 10px;
    }
  </style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.channel-header').forEach(header => {
      header.addEventListener('click', () => {
        const channelId = header.dataset.id;
        const videoList = document.getElementById('videos-' + channelId);
        const arrow = document.getElementById('arrow-' + channelId);
        const isOpen = videoList.style.display === 'block';

        // Alterna visibilidade
        videoList.style.display = isOpen ? 'none' : 'block';

        // Atualiza seta
        arrow.textContent = isOpen ? '▶' : '▼';

        // Alterna classe 'open' para animações
        header.classList.toggle('open');
      });

      // Remove atributo inline onclick (evita conflitos)
      header.removeAttribute('onclick');
    });
  });
</script>


<?php endif; ?>
