from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask_migrate import Migrate
import time
import sqlalchemy

app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql+pymysql://videoforge:videoforgepassword@db:3306/videoforge_db'
app.config['SQLALCHEMY_TRACK_MODIFICATIONS'] = False

db = SQLAlchemy(app)
migrate = Migrate(app, db)

# Loop para aguardar o MySQL ficar pronto antes de continuar.
for i in range(5):
    try:
        engine = sqlalchemy.create_engine(app.config['SQLALCHEMY_DATABASE_URI'])
        conn = engine.connect()
        conn.close()
        print("Banco de dados disponível!")
        break
    except Exception as e:
        print("Banco não acessível, tentando novamente em 5 segundos...")
        time.sleep(5)

# Importa os modelos para que o Flask-Migrate os reconheça
from app import models
