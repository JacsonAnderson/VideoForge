<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VideoForge - Plataforma</title>
  <link rel="stylesheet" href="static/style.css">
</head>
<body>
  <div class="container">
    <!-- Sidebar (incluído via partial) -->
    <?php include 'partials/sidebar.php'; ?>

    <!-- Área principal -->
    <main class="main-content">
      <!-- Cabeçalho (incluído via partial) -->
      <?php include 'partials/header-content.php'; ?>
      
      <div class="separator-horizontal"></div>
      
      <section class="content">
        <div class="welcome">
          <h2>Bem-vindo à Plataforma VideoForge</h2>
          <p>
            Uma solução completa para a automatização da criação de vídeos no estilo "faceless". 
            Gerencie seus canais, edite vídeos, gere roteiros e muito mais com uma interface moderna e intuitiva.
          </p>
        </div>
        <div class="features">
          <div class="feature-card">
            <h3>Gerar Roteiro</h3>
            <p>Utilize inteligência artificial para criar roteiros detalhados a partir dos seus prompts.</p>
          </div>
          <div class="feature-card">
            <h3>Gerar Áudio</h3>
            <p>Converta textos em áudio com vozes realistas e personalizáveis.</p>
          </div>
          <div class="feature-card">
            <h3>Editar Vídeo</h3>
            <p>Edite e aperfeiçoe seus vídeos com ferramentas intuitivas.</p>
          </div>
        </div>
      </section>

      <!-- Rodapé (incluído via partial) -->
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
