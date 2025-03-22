<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel de Conteúdo - VideoForge</title>
  <link rel="stylesheet" href="static/style.css">
  <style>
    /* Estilos da toolbar */
    .toolbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 30px;
      margin-bottom: 20px;
      padding: 0 50px;
    }
    .toolbar-center {
      flex: 1;
      text-align: center;
    }
    .toolbar .btn {
      padding: 15px 25px;
      background: linear-gradient(45deg, #3a3a3a, #2a2a2a);
      color: #F3F3F3;
      border: none;
      border-radius: 8px;
      font-size: 1.2em;
      cursor: pointer;
      transition: transform 0.2s, background 0.3s, box-shadow 0.3s;
    }
    .toolbar .btn:hover {
      transform: scale(1.05);
      box-shadow: 0 0 5px #8B32F4;
    }
    .add-video-btn {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: linear-gradient(45deg, #3a3a3a, #2a2a2a);
      border: none;
      color: #F3F3F3;
      font-size: 2em;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform 0.2s, background 0.3s, box-shadow 0.3s;
    }
    .add-video-btn:hover {
      transform: scale(1.1);
      box-shadow: 0 0 5px #8B32F4;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php include 'partials/sidebar.php'; ?>

    <main class="main-content">
      <?php include 'partials/header-content.php'; ?>
      
      <div class="toolbar">
        <div class="toolbar-left"></div>
        <div class="toolbar-center">
          <button id="openModalBtn" class="btn">Gerenciar Canais</button>
        </div>
        <div class="toolbar-right">
          <button id="openAddVideoBtn" class="add-video-btn">+</button>
        </div>
      </div>

      <div class="separator-horizontal"></div>

      <!-- Removido o <section> fixo -->
      
      <?php include 'videos/channel_video_view.php'; ?>

      <?php include 'partials/footer.php'; ?>
    </main>
  </div>

  <?php include 'channels/modal.php'; ?> 
  <?php include 'channels/create_channel_modal.php'; ?>
  <?php include 'videos/add_video_modal.php'; ?> 

  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebar-toggle');
    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
    });
  </script>
</body>
</html>
