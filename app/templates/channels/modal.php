<!-- app/templates/channels/modal.php -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <div class="modal-header">
      <button id="openCreateChannelBtn" class="btn create-channel-btn">Criar Canal</button>
    </div>
    <div class="modal-body">
      <!-- Aqui você poderá inserir a listagem de canais ou outros conteúdos futuramente -->
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById('myModal');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModal = modal.querySelector('.close-modal');

    if (openModalBtn) {
      openModalBtn.addEventListener('click', function() {
        modal.style.display = "block";
      });
    }

    if (closeModal) {
      closeModal.addEventListener('click', function() {
        modal.style.display = "none";
      });
    }

    window.addEventListener('click', function(event) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    });
  });
</script>

<style>
  /* Modal Styles */
  .modal {
    display: none; /* Oculto inicialmente */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5); /* Fundo semi-transparente */
  }
  .modal-content {
    background: linear-gradient(45deg, #8B32F4, #5320A6);
    color: #fff;
    margin: 100px auto; /* Centraliza verticalmente com margem */
    padding: 20px;
    border: 1px solid #888;
    width: 800px;
    height: 600px;
    position: relative;
    overflow-y: auto;
  }
  .close-modal {
    color: #aaa;
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }
  .close-modal:hover,
  .close-modal:focus {
    color: black;
    text-decoration: none;
  }
  .modal-header {
    text-align: center;
    margin-bottom: 20px; /* Espaço abaixo do botão */
  }
  .create-channel-btn {
    padding: 10px 20px;
    background: linear-gradient(45deg, #8B32F4, #5320A6);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 1.2em;
    cursor: pointer;
    transition: transform 0.2s, background 0.3s;
  }
  .create-channel-btn:hover {
    transform: scale(1.05);
  }
  .modal-body {
    /* Estilos adicionais para o conteúdo do modal, se necessário */
  }
</style>

