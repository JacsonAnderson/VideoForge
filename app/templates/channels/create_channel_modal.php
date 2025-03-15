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
  const openCreateChannelBtn = document.getElementById('openCreateChannelBtn');
  const closeModal = createChannelModal.querySelector('.close-modal');
  const createChannelForm = document.getElementById('createChannelForm');

  function closeModalFunc() {
    createChannelModal.style.display = "none";
  }

  if (openCreateChannelBtn) {
    openCreateChannelBtn.addEventListener('click', function() {
      createChannelModal.style.display = "block";
    });
  }

  if (closeModal) {
    closeModal.addEventListener('click', function() {
      closeModalFunc();
    });
  }

  window.addEventListener('click', function(event) {
    if (event.target === createChannelModal) {
      closeModalFunc();
    }
  });

  createChannelForm.addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(createChannelForm);
    fetch(createChannelForm.action, {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        closeModalFunc();
        showNotification(data.message, true);
      } else {
        showNotification(data.message, false);
      }
    })
    .catch(error => {
      showNotification("Erro na comunicação com o servidor.", false);
      console.error("Erro:", error);
    });
  });

  function showNotification(message, isSuccess) {
    let notification = document.getElementById('notification');
    if (!notification) {
      notification = document.createElement('div');
      notification.id = 'notification';
      notification.style.position = 'fixed';
      notification.style.top = '100px';
      notification.style.left = '50%';
      notification.style.transform = 'translateX(-50%)';
      notification.style.padding = '15px 30px';
      notification.style.borderRadius = '8px';
      notification.style.zIndex = '1100';
      notification.style.fontSize = '1.2em';
      notification.style.boxShadow = '0 4px 8px rgba(0,0,0,0.3)';
      document.body.appendChild(notification);
    }

    notification.innerHTML = message;
    notification.style.background = isSuccess 
      ? 'linear-gradient(45deg, #32CD32, #228B22)' 
      : 'linear-gradient(45deg, #FF6347, #FF4500)';
    notification.style.color = '#fff';
    notification.style.display = 'block';

    setTimeout(function() {
      notification.style.display = 'none';
    }, 5000);
  }
});
</script>

<style>
  .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
  }

  .modal-content {
    background: linear-gradient(45deg, #8B32F4, #5320A6);
    color: #fff;
    margin: 100px auto;
    padding: 20px;
    border: 1px solid #888;
    width: 800px;
    height: 600px;
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

  .form-group {
    margin-bottom: 15px;
  }

  .form-group label {
    display: block;
    margin-bottom: 5px;
  }

  .form-group input,
  .form-group textarea {
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
