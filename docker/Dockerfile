FROM python:3.11-slim

# Define o diretório de trabalho no container
WORKDIR /app

# Copia o requirements.txt e instala as dependências
COPY requirements.txt .
RUN pip install --no-cache-dir -r requirements.txt

# Copia os arquivos da aplicação: main.py, templates e static
COPY app/main.py .
COPY app/templates/ templates/
COPY app/static/ static/

# Exponha a porta onde a aplicação Flask vai rodar (1313, por exemplo)
EXPOSE 1313

# Comando para iniciar o servidor Flask
CMD ["python", "main.py"]
