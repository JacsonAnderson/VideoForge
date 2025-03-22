<!-- add_video_modal.php -->
<link rel="stylesheet" href="static/style_video.css">

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
          <select id="channelSelect" name="channelId" required></select>
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

  // Carrega os canais para o select
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

  // Abre o modal e carrega os canais
  if (openAddVideoBtn) {
    openAddVideoBtn.addEventListener('click', function() {
      addVideoModal.style.display = "block";
      fetchChannels();
    });
  }

  // Fecha o modal
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

  // Envio do formulário via AJAX
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
    .then(response => {
      if (!response.ok) {
        // Se o status não for OK, lança um erro
        return response.text().then(text => { throw new Error(text || response.statusText); });
      }
      return response.json();
    })
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

  // Função de notificação
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
    setTimeout(() => { notification.style.opacity = '1'; }, 100);
    setTimeout(() => {
      notification.style.opacity = '0';
      setTimeout(() => { notification.remove(); }, 500);
    }, 5000);
  }
});
</script>
