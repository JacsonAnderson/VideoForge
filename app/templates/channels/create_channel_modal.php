<!-- app/templates/channels/create_channel_modal.php -->
<div id="createChannelModal" class="modal">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <div class="modal-header">
      <h2>Criar Novo Canal</h2>
    </div>
    <div class="modal-body">
    <form id="createChannelForm" action="channels/create_channel.php" method="post">
        <div class="form-group">
          <label for="channelName">Nome:</label>
          <input type="text" id="channelName" name="channelName" required>
        </div>
        <div class="form-group">
          <label for="channelLanguage">Língua:</label>
          <input type="text" id="channelLanguage" name="channelLanguage" required>
        </div>
        <div class="form-group">
          <label for="minPromptChars">Min Prompt Chars:</label>
          <input type="number" id="minPromptChars" name="minPromptChars">
        </div>
        <div class="form-group">
          <label for="channelPrompt">Prompt:</label>
          <textarea id="channelPrompt" name="channelPrompt" rows="4" required></textarea>
        </div>
        <div class="form-group">
          <label for="voiceModel">Voice Model:</label>
          <input type="text" id="voiceModel" name="voiceModel">
        </div>
        <div class="form-group">
          <label for="watermark">Watermark:</label>
          <input type="text" id="watermark" name="watermark">
        </div>
        <div class="form-group">
          <label for="music">Music:</label>
          <input type="text" id="music" name="music">
        </div>
        <div class="form-group" style="text-align: center;">
          <button type="submit" class="btn submit-btn">Salvar Canal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const createChannelModal = document.getElementById('createChannelModal');
  const openCreateChannelBtn = document.getElementById('openCreateChannelBtn'); // Este botão deve existir na interface principal para abrir o modal
  const closeModal = createChannelModal.querySelector('.close-modal');

  if (openCreateChannelBtn) {
    openCreateChannelBtn.addEventListener('click', function() {
      createChannelModal.style.display = "block";
    });
  }

  if (closeModal) {
    closeModal.addEventListener('click', function() {
      createChannelModal.style.display = "none";
    });
  }

  window.addEventListener('click', function(event) {
    if (event.target === createChannelModal) {
      createChannelModal.style.display = "none";
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
    height: 1000px;
    position: relative;
    overflow-y: auto;
    border-radius: 8px;
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
    margin-bottom: 20px;
  }
  .modal-body {
    /* Espaço para o conteúdo do formulário */
  }
  .form-group {
    margin-bottom: 15px;
  }
  .form-group label {
    display: block;
    margin-bottom: 5px;
  }
  .form-group input,
  .form-group textarea,
  .form-group select {
    width: 100%;
    padding: 8px;
    border: none;
    border-radius: 4px;
  }
  .submit-btn {
    background: linear-gradient(45deg, #8B32F4, #5320A6);
    font-size: 1.2em;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    color: #fff;
    transition: transform 0.2s, background 0.3s;
  }
  .submit-btn:hover {
    transform: scale(1.05);
  }
</style>
