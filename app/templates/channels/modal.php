<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close-modal">&times;</span>
    <div class="modal-header">
      <button id="openCreateChannelBtn" class="btn create-channel-btn">Criar Canal</button>
    </div>
    <div class="modal-body">
      <h3>Lista de Canais</h3>
      <table id="channelsTable">
        <tbody>
          <!-- Os canais serão carregados aqui dinamicamente -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById('myModal');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModal = modal.querySelector('.close-modal');
    const channelsTableBody = document.querySelector('#channelsTable tbody');

    if (openModalBtn) {
      openModalBtn.addEventListener('click', function () {
        modal.style.display = "block";
        fetchChannels();
      });
    }

    if (closeModal) {
      closeModal.addEventListener('click', function () {
        modal.style.display = "none";
      });
    }

    window.addEventListener('click', function (event) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    });

    function fetchChannels() {
      fetch('channels/list_channels.php')
        .then(response => response.json())
        .then(data => {
          channelsTableBody.innerHTML = '';
          if (data.status === 'success' && data.data.length > 0) {
            data.data.forEach(channel => {
              const row = `
                <tr class="channel-row">
                  <td>
                    <div class="channel-info">
                      <div class="channel-name">${channel.name}</div>
                      <div class="channel-language">${channel.language}</div>
                    </div>
                  </td>
                  <td class="channel-actions">
                    <button class="action-btn edit-btn" title="Editar">
                      ✏️
                    </button>
                    <button class="action-btn delete-btn" title="Excluir" 
                      data-id="${channel.id}" data-name="${channel.name}">
                      ❌
                    </button>
                  </td>
                </tr>`;
              channelsTableBody.innerHTML += row;
            });

            document.querySelectorAll('.delete-btn').forEach(button => {
              button.addEventListener('click', function () {
                const channelId = this.getAttribute('data-id');
                const channelName = this.getAttribute('data-name');
                confirmDelete(channelId, channelName);
              });
            });

          } else {
            channelsTableBody.innerHTML = `<tr><td colspan="2">Nenhum canal encontrado.</td></tr>`;
          }
        })
        .catch(error => {
          console.error('Erro ao buscar canais:', error);
          channelsTableBody.innerHTML = `<tr><td colspan="2">Erro ao carregar os canais.</td></tr>`;
        });
    }

    function confirmDelete(channelId, channelName) {
      const userInput = prompt(`Digite o nome do canal para confirmar a exclusão: "${channelName}"`);

      if (userInput && userInput.trim() === channelName) {
        deleteChannel(channelId, channelName);
      } else if (userInput) {
        alert('Nome do canal incorreto. Exclusão cancelada.');
      }
    }

    function deleteChannel(channelId, channelName) {
      fetch(`channels/delete_channel.php`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: channelId })
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          alert(`Canal "${channelName}" excluído com sucesso.`);
          fetchChannels();
        } else {
          alert(`Erro ao excluir canal: ${data.message}`);
        }
      })
      .catch(error => {
        console.error('Erro ao excluir o canal:', error);
      });
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

  .channel-info {
    display: flex;
    flex-direction: column;
    padding: 10px;
  }

  .channel-name {
    font-weight: bold;
    font-size: 1.1em;
  }

  .channel-language {
    font-size: 0.9em;
    color: #ccc;
    margin-top: 4px;
  }

  .channel-actions {
    text-align: right;
    padding-right: 20px;
  }

  .action-btn {
    background: transparent;
    border: none;
    cursor: pointer;
    font-size: 1.5em;
    padding: 0 5px;
  }

  .edit-btn {
    color: #32CD32;
  }

  .delete-btn {
    color: #FF6347;
  }

  .action-btn:hover {
    transform: scale(1.1);
  }

  table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
    margin-top: 20px;
  }

  .channel-row {
    background: #3c2574;
    padding: 10px;
    border-radius: 8px;
  }
</style>
