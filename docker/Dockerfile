FROM python:3.11-slim

# Define o diretório de trabalho no container
WORKDIR /app

# Copia o requirements.txt e instala as dependências
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Copia a pasta inteira "app" para o container
COPY app/ app/

# Exponha a porta onde a aplicação Flask vai rodar
EXPOSE 1313

# Inicia a aplicação Flask como módulo
CMD ["python", "-m", "app.main"]
