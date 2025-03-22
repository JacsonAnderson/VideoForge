<div id="addVideoModal" class="modal">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <div class="modal-header">
      <h2>Adicionar Novo Vídeo</h2>
    </div>
    <div class="modal-body">
      <form id="addVideoForm" action="videos/add_video.php" method="post">
        <div class="form-group">
          <label for="channelSelect">Selecione o Canal:</label>
          <select id="channelSelect" name="channelId" required>
            <!-- As opções serão preenchidas dinamicamente com os canais existentes -->
          </select>
        </div>
        <div class="form-group">
          <label for="referenceLink">Link de Referência:</label>
          <input type="url" id="referenceLink" name="referenceLink" placeholder="https://exemplo.com" required>
        </div>
        <div class="form-group" style="text-align: center;">
          <button type="submit" class="btn submit-btn">Salvar Vídeo</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const addVideoModal = document.getElementById('addVideoModal');
  const openAddVideoBtn = document.getElementById('openAddVideoBtn');
  const closeModal = addVideoModal.querySelector('.close-modal');
  const addVideoForm = document.getElementById('addVideoForm');
  const channelSelect = document.getElementById('channelSelect');
  const referenceLink = document.getElementById('referenceLink');

  function fetchChannels() {
    fetch('channels/list_channels.php')
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success' && data.data.length > 0) {
          channelSelect.innerHTML = '';
          data.data.forEach(channel => {
            const option = document.createElement('option');
            option.value = channel.id;
            option.textContent = channel.name;
            channelSelect.appendChild(option);
          });
        } else {
          channelSelect.innerHTML = '<option value="">Nenhum canal encontrado</option>';
        }
      })
      .catch(error => {
        console.error('Erro ao buscar canais:', error);
        channelSelect.innerHTML = '<option value="">Erro ao carregar canais</option>';
      });
  }

  if (openAddVideoBtn) {
    openAddVideoBtn.addEventListener('click', function() {
      addVideoModal.style.display = "block";
      fetchChannels();
    });
  }

  if (closeModal) {
    closeModal.addEventListener('click', function() {
      addVideoModal.style.display = "none";
    });
  }

  window.addEventListener('click', function(event) {
    if (event.target === addVideoModal) {
      addVideoModal.style.display = "none";
    }
  });

  addVideoForm.addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(addVideoForm);
    const submitBtn = addVideoForm.querySelector('.submit-btn');
    submitBtn.disabled = true;

    fetch(addVideoForm.action, {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.json())
    .then(data => {
      submitBtn.disabled = false;
      addVideoModal.style.display = "none";
      showNotification(data.message, data.status === 'success');

      if (data.status === 'success') {
        referenceLink.value = '';
      }
    })
    .catch(error => {
      submitBtn.disabled = false;
      showNotification("Erro na comunicação com o servidor.", false);
      console.error("Erro:", error);
    });
  });

  function showNotification(message, isSuccess) {
    const existingNotification = document.getElementById('notification');
    if (existingNotification) {
      existingNotification.remove();
    }

    const notification = document.createElement('div');
    notification.id = 'notification';
    notification.textContent = message;
    notification.style.position = 'fixed';
    notification.style.top = '100px';
    notification.style.left = '50%';
    notification.style.transform = 'translateX(-50%)';
    notification.style.padding = '15px 30px';
    notification.style.borderRadius = '8px';
    notification.style.zIndex = '1100';
    notification.style.fontSize = '1.2em';
    notification.style.boxShadow = '0 4px 8px rgba(0,0,0,0.3)';
    notification.style.opacity = '0';
    notification.style.transition = 'opacity 0.5s ease';
    notification.style.background = isSuccess 
      ? 'linear-gradient(45deg, #32CD32, #228B22)' 
      : 'linear-gradient(45deg, #FF6347, #FF4500)';
    notification.style.color = '#fff';

    document.body.appendChild(notification);

    setTimeout(() => {
      notification.style.opacity = '1';
    }, 100);

    setTimeout(() => {
      notification.style.opacity = '0';
      setTimeout(() => {
        notification.remove();
      }, 500);
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
    background: linear-gradient(45deg, #2a2a2a, #1e1e1e);
    color: #F3F3F3;
    margin: 100px auto;
    padding: 20px;
    border: 1px solid #3f3f3f;
    width: 800px;
    max-height: 80%;
    position: relative;
    overflow-y: auto;
    border-radius: 8px;
  }

  .close-modal {
    color: #ccc;
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }

  .close-modal:hover,
  .close-modal:focus {
    color: #8B32F4;
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
  .form-group select {
    width: 100%;
    padding: 8px;
    border: 1px solid #3f3f3f;
    border-radius: 4px;
    background-color: #2a2a2a;
    color: #F3F3F3;
  }

  .submit-btn {
    background: linear-gradient(45deg, #2a2a2a, #1e1e1e);
    font-size: 1.2em;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    color: #F3F3F3;
    border: none;
    transition: transform 0.2s, background 0.3s, box-shadow 0.3s;
  }

  .submit-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 0 5px #8B32F4;
  }
</style>
