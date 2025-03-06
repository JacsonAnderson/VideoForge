from flask import Flask, render_template
import webbrowser
import threading

app = Flask(__name__)

@app.route("/")
def index():
    return render_template("index.html")  # Certifique-se de ter esse template em templates/index.html

def open_browser():
    webbrowser.open_new("http://localhost:1313")

if __name__ == "__main__":
    # Inicia um timer para abrir o navegador 1 segundo após o servidor iniciar
    threading.Timer(1, open_browser).start()
    # Inicia o servidor na porta 1313
    app.run(host="127.0.0.1", port=1313, debug=True)
