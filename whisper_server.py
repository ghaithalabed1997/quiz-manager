from flask import Flask, request, jsonify
import whisper
import os
from werkzeug.utils import secure_filename

app = Flask(__name__)
model = whisper.load_model("base")  # or "tiny", "medium", "large"

@app.route("/transcribe", methods=["POST"])
def transcribe():
    if "audio" not in request.files:
        return jsonify({"error": "No audio file provided"}), 400

    file = request.files["audio"]
    filename = secure_filename(file.filename)
    file_path = os.path.join("temp", filename)
    
    os.makedirs("temp", exist_ok=True)
    file.save(file_path)

    result = model.transcribe(file_path)
    os.remove(file_path)

    return jsonify({"text": result["text"]})

if __name__ == "__main__":
    app.run(port=5005)
