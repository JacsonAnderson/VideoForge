<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel de Conteúdo</title>
  <link rel="stylesheet" href="static/style.css">
  <style>
    /* Estilos específicos para a página Content Dashboard */
    .toolbar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 30px; /* Espaço abaixo do header */
      margin-bottom: 20px;
      padding: 0 50px; /* Espaço horizontal para as laterais */
    }
    .toolbar-center {
      flex: 1;
      text-align: center;
    }
    .toolbar .btn {
      padding: 15px 25px;
      background: linear-gradient(45deg, #8B32F4, #5320A6);
      color: #fff;
      border: none;
      border-radius: 8px;
      font-size: 1.2em;
      cursor: pointer;
      transition: transform 0.2s, background 0.3s;
    }
    .toolbar .btn:hover {
      transform: scale(1.05);
    }
    /* Botão "Adicionar Vídeo" - redondo e alinhado à direita, com 50px de distância */
    .add-video-btn {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: linear-gradient(45deg, #8B32F4, #5320A6);
      border: none;
      color: #fff;
      font-size: 2em;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform 0.2s, background 0.3s;
    }
    .add-video-btn:hover {
      transform: scale(1.1);
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Inclui a Sidebar -->
    <?php include 'partials/sidebar.php'; ?>

    <!-- Área principal -->
    <main class="main-content">
      <!-- Cabeçalho -->
      <?php include 'partials/header-content.php'; ?>
      
      <!-- Barra de Ferramentas -->
      <div class="toolbar">
        <div class="toolbar-left">
          <!-- Espaço para conteúdo à esquerda, se necessário -->
        </div>
        <div class="toolbar-center">
          <button class="btn" onclick="location.href='content_dashboard.php'">Gerenciar Canais</button>
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
        <!-- Insira aqui a lista de canais e vídeos, com suas funcionalidades -->
      </section>

      <!-- Inclui o Rodapé -->
      <?php include 'partials/footer.php'; ?>
    </main>
  </div>

  <!-- Script para alternar a sidebar -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebar-toggle');
    toggleBtn.addEventListener('click', function() {
      sidebar.classList.toggle('collapsed');
    });
  </script>
</body>
</html>
