import random
import string
from datetime import datetime
from flask_sqlalchemy import SQLAlchemy

db = SQLAlchemy()

def generate_channel_id():
    """Gera um ID único de 16 caracteres (letras maiúsculas e dígitos) para o canal."""
    return ''.join(random.choices(string.ascii_uppercase + string.digits, k=16))

class Channel(db.Model):
    __tablename__ = 'channels'
    id = db.Column(db.String(16), primary_key=True, default=generate_channel_id)
    name = db.Column(db.String(128), nullable=False)
    language = db.Column(db.String(64), nullable=False)
    min_prompt_chars = db.Column(db.Integer, nullable=True)
    prompt = db.Column(db.Text, nullable=False)  # Suporta textos extensos (20-30k caracteres)
    voice_model = db.Column(db.String(128), nullable=True)
    watermark = db.Column(db.String(128), nullable=True)
    music = db.Column(db.String(128), nullable=True)
    created_at = db.Column(db.DateTime, default=datetime.utcnow)

    def __repr__(self):
        return f"<Channel {self.name} ({self.id})>"
