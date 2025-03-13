from flask import Flask, render_template
from app import app, db
from app.models import Channel
import webbrowser
import threading
import os

app = Flask(__name__)

@app.route("/")
def index():
    return render_template("index.html")  # Certifique-se de ter esse template em templates/index.html

def open_browser():
    webbrowser.open_new("http://localhost:1313")

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=1313, debug=True)


