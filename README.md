# 🎬 VideoForge - Automação de Criação de Vídeos No Faceless

<p align="center">
  <img src="app/static/assets/logo.png" alt="VideoForge Banner" width="400">
</p>

> Uma ferramenta poderosa para automatizar a criação de vídeos No Faceless, otimizando todo o fluxo de produção para criadores de conteúdo digital.

## 🚀 Sobre o VideoForge

**VideoForge** é uma solução completa para gerenciar canais, agendar postagens e criar vídeos de forma automática. O sistema combina geração de roteiros, síntese de voz, seleção de mídia e edição automatizada para facilitar a produção de conteúdo em massa.


## ✨ Recursos Principais

- **Ainda nenhum** – Conforme os recursos forem ficando prontos, irei listá-los aqui.
- **Painel de Conteúdo** – Espaço exclusivo para gerenciar seus canais e vídeos. Muitos recursos ainda estão em fase de teste.

## ✨ Recursos Disponíveis para Uso 🔨 (Ainda em Teste)

- **Criação de Canais** – Você já pode adicionar seu canal e excluí-lo caso cometa algum erro. O canal já está conectado ao banco de dados SQL. (Futuramente, adicionarei a função de modificar o canal).

## 🔨 Em Desenvolvimento

- 📆 **Agenda Inteligente** para gerenciar datas de postagem.
- 📺 **Gestão de Canais** para organização dos projetos.
- 🎙️ **Geração de Áudio** com Piper.
- 🎞️ **Edição de Vídeos** e seleção otimizada de mídias.
- 🤖 **Modo AutoForge**: fluxo automatizado de produção de vídeos.
- 💾 **Banco de Dados Robusto** para armazenamento eficiente.
- 🛠️ **Ferramentas Modulares** para uso independente.
- 🔄 **Treinamento de Modelo de Voz Próprio**.
- 🖼️ **Gerador de Capas Automático**.
- 🕹️ **Dashboard Interativo** com estatísticas.
- 📡 **Integrações com Plataformas de Vídeo** (YouTube, TikTok, etc.).


## ⚙️ Como Instalar (Nativo, com Docker Desktop)

Nesta versão, a instalação é feita via Docker. Se você ainda não tem o Docker Desktop instalado, siga os passos abaixo.

### 1. Instalar o Docker Desktop

- Acesse o site oficial do Docker Desktop: [https://www.docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop)  
- Baixe e instale o Docker Desktop para o seu sistema operacional (Windows ou macOS).  
- Após a instalação, abra o Docker Desktop e verifique se ele está em execução.

### 2. Clonar o Repositório

Abra o terminal (ou Git Bash) e execute:

```sh
git clone https://github.com/JacsonAnderson/VideoForge.git
```

Isso criará uma pasta chamada `VideoForge` com toda a estrutura do projeto.

### 3. Navegar até o Diretório do Projeto

No terminal, acesse o diretório do projeto:

```sh
cd VideoForge\docker
```

### 4. Construir e Iniciar os Containers

Utilize o Docker Compose para construir as imagens e iniciar os containers. Execute:

```sh
docker-compose up -d --build
```

Este comando fará o seguinte:
- **Construir a imagem do aplicativo Flask:** O Dockerfile (localizado em `docker/Dockerfile`) instalará as dependências definidas no `requirements.txt` e copiará os arquivos da aplicação.
- **Iniciar o container do MySQL:** Usando a imagem oficial do MySQL com as variáveis de ambiente definidas.
- **Iniciar o container do Nginx:** Que gerencia as portas e faz o proxy reverso para sua aplicação Flask.

### Tenho que numerar isso aqui tambem porem vou fazer depois

execute o install.bat

tambem rode este codigo ( Vou automatizar ele em um futuro proximo! )
docker-compose exec app php /var/www/app/migrations/create_channels_table.php

esse aqui tambem para Criar as Pastas de armazenamento
mkdir data\bancodevideos
mkdir data\channels

### 5. Acessar a Aplicação

Após iniciar os containers, abra o navegador e acesse:

```
http://localhost:1313
```

O Nginx redirecionará a requisição para sua aplicação Flask, que estará rodando na porta 1313 internamente.

### 6. Atualizações e Manutenção

- Para aplicar alterações ou atualizar o código, faça as mudanças no repositório e depois execute:
  ```sh
  docker-compose up -d --build
  ```
- Os dados persistentes (como os do MySQL) são mantidos na pasta `data/`, conforme mapeado no arquivo `docker-compose.yml`.

---

## 📷 Exemplo Visual

Em breve, adicionarei imagens ou GIFs demonstrando o funcionamento do VideoForge.

## 🔗 Contato

Para mais informações, entre em contato:
**Email:** Jacson11anderson.jsn@gmail.com

---

⚡ *Este README será atualizado conforme o projeto evolui.*

---


