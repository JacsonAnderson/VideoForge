#!/bin/sh

# Se o arquivo .env não existir, cria a partir do .env.example
if [ ! -f .env ]; then
    echo "Criando .env a partir de .env.example..."
    cp .env.example .env
else
    echo ".env já existe, mantendo os valores atuais."
fi

# Continua a execução do container normalmente
exec "$@"
