from flask import Flask, request, jsonify
from flask_cors import CORS
import os
import json
import uuid
import numpy as np
from PIL import Image, UnidentifiedImageError
import tensorflow as tf
from tensorflow.keras.applications import efficientnet_v2

# ============================
#           CONFIG
# ============================
IMAGE_SIZE = (256, 256)
LABEL_PATH = 'models/label_to_index.json'
HDF5_MODEL_PATH = 'models/cnn_model.h5'

ALLOWED_EXTENSIONS = {'jpg', 'jpeg', 'png'}

app = Flask(__name__)
CORS(app)

# ============================
#        HELPER FUNCTION
# ============================
def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS


def is_leaf_like(image_rgb):
    """
    FILTER GAMBAR:
    cek dominasi warna hijau (daun)
    """
    img = np.array(image_rgb)

    r = img[:, :, 0].astype(np.float32)
    g = img[:, :, 1].astype(np.float32)
    b = img[:, :, 2].astype(np.float32)

    green_pixels = (g > r) & (g > b) & (g > 40)
    green_ratio = np.sum(green_pixels) / green_pixels.size

    return green_ratio > 0.15   # threshold daun


# ============================
#      LOAD LABEL MAPPING
# ============================
if os.path.exists(LABEL_PATH):
    with open(LABEL_PATH, 'r') as f:
        label_to_index = json.load(f)
else:
    label_to_index = {
        'angular_leaf_spot': 0,
        'healthy': 1,
        'leaf_scorch': 2
    }

index_to_label = {int(v): k for k, v in label_to_index.items()}
num_classes = len(index_to_label)

# ============================
#        LOAD MODEL
# ============================
try:
    model = tf.keras.models.load_model(HDF5_MODEL_PATH, compile=False)
except:
    model = tf.keras.Sequential([
        tf.keras.layers.Input(shape=(IMAGE_SIZE[0], IMAGE_SIZE[1], 3)),
        tf.keras.layers.GlobalAveragePooling2D(),
        tf.keras.layers.Dense(num_classes, activation='softmax')
    ])
    model.compile(optimizer='adam', loss='sparse_categorical_crossentropy')


def is_efficientnet(m):
    return "efficientnet" in getattr(m, "name", "").lower()


# ============================
#      DISPLAY DATA
# ============================
DISPLAY_NAME = {
    'healthy': 'Daun Sehat',
    'leaf_scorch': 'Gosong Daun',
    'angular_leaf_spot': 'Bercak Daun Sudut'
}

DESCRIPTION = {
    'Daun Sehat':
        'Daun sehat tanpa gejala penyakit. Lanjutkan perawatan rutin agar tanaman tetap optimal.',
    'Gosong Daun':
        'Daun mengalami pengeringan atau kecokelatan pada tepi, biasanya akibat panas atau kurang air.',
    'Bercak Daun Sudut':
        'Daun memiliki bercak cokelat kehitaman berbentuk sudut, umumnya disebabkan infeksi jamur atau bakteri.'
}

TREATMENT = {
    'Daun Sehat':
        'Lakukan penyiraman teratur, pemupukan seimbang, serta jaga sirkulasi udara.',
    'Gosong Daun':
        'Hindari matahari berlebih, tingkatkan kelembaban tanah, dan berikan pupuk kalium.',
    'Bercak Daun Sudut':
        'Pangkas daun terinfeksi, hindari penyiraman dari atas, dan gunakan fungisida.'
}

# ============================
#        API PREDICT
# ============================
@app.route('/predict', methods=['POST'])
def predict():
    try:
        uploaded = request.files.get('image') or request.files.get('file')

        if not uploaded:
            return jsonify({'error': 'Tidak ada file yang diunggah'}), 400

        if not allowed_file(uploaded.filename):
            return jsonify({'error': 'File harus berupa JPG atau PNG'}), 400

        os.makedirs("uploads", exist_ok=True)
        filename = f"{uuid.uuid4()}_{uploaded.filename}"
        save_path = os.path.join("uploads", filename)
        uploaded.save(save_path)

        # Validasi gambar
        try:
            img = Image.open(save_path)
            img.verify()
            img = Image.open(save_path).convert("RGB").resize(IMAGE_SIZE)
        except (UnidentifiedImageError, OSError):
            return jsonify({'error': 'File bukan gambar valid'}), 400

        # ================= FILTER DAUN =================
        if not is_leaf_like(img):
            return jsonify({
                "error": "Gambar tidak terdeteksi sebagai daun stroberi. "
                         "Silakan unggah gambar daun."
            }), 400

        arr = np.array(img).astype("float32")

        if is_efficientnet(model):
            processed = efficientnet_v2.preprocess_input(np.copy(arr))
        else:
            processed = arr / 255.0

        input_batch = np.expand_dims(processed, axis=0)

        preds = model.predict(input_batch)
        probs = preds[0] if preds.ndim > 1 else preds

        pred_idx = int(np.argmax(probs))
        raw_label = index_to_label.get(pred_idx, "unknown")
        formatted_label = DISPLAY_NAME.get(raw_label, raw_label)

        prob = float(probs[pred_idx])

        description = DESCRIPTION.get(formatted_label, "Tidak ada deskripsi.")
        treatment = TREATMENT.get(formatted_label, "Tidak ada penanganan.")

        return jsonify({
            "label": formatted_label,
            "probability": prob,
            "description": description,
            "treatment": treatment,
            "image_name": filename
        }), 200

    except Exception as e:
        return jsonify({
            'error': 'Internal server error',
            'detail': str(e)
        }), 500


# ============================
#            ROOT
# ============================
@app.route('/', methods=['GET'])
def index():
    return jsonify({
        "status": "ok",
        "message": "Server Deteksi Daun Stroberi Aktif"
    })


# ============================
#            RUN
# ============================
if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
