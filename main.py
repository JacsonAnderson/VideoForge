from flask import Flask, render_template
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
    # Abre o navegador apenas se esse for o processo principal
    if os.environ.get("WERKZEUG_RUN_MAIN") == "true":
        threading.Timer(1, open_browser).start()
    app.run(host="127.0.0.1", port=1313, debug=True)

