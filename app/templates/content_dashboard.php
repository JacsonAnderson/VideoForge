<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel de Conteúdo - VideoForge</title>
  <link rel="stylesheet" href="static/style.css">
  <style>
    /* Estilos para a página Painel de Conteúdo */
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
        <div class="toolbar-left">
          <!-- Espaço para conteúdo à esquerda, se necessário -->
        </div>
        <div class="toolbar-center">
          <!-- Botão que abre o modal -->
          <button id="openModalBtn" class="btn">Gerenciar Canais</button>
        </div>
        <div class="toolbar-right">
          <button class="add-video-btn" onclick="location.href='adicionar_video.php'">+</button>
        </div>
      </div>

      <div class="separator-horizontal"></div>
      
      <section class="content">
        <h2>Painel de Conteúdo</h2>
        <p>
          Neste painel, você poderá gerenciar canais e vídeos. Visualize, edite e organize os canais,
          adicione novos vídeos, acompanhe o status de produção e defina tags para controlar o processo.
        </p>
      </section>

      <?php include 'partials/footer.php'; ?>
    </main>
  </div>

  <!-- Inclui o módulo do Modal -->
  <?php include 'channels/modal.php'; ?>

  <!-- Inclui o módulo do create_channel_modal -->
  <?php include 'channels/create_channel_modal.php'; ?>
  
  <script>
    // Lógica para alternar a sidebar
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebar-toggle');
    toggleBtn.addEventListener('click', function() {
      sidebar.classList.toggle('collapsed');
    });
  </script>
</body>
</html>
