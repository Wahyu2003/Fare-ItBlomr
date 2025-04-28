from flask import Flask, request, jsonify
from flask_cors import CORS
import face_recognition
import numpy as np
import requests

app = Flask(__name__)
app.config['MAX_CONTENT_LENGTH'] = 24 * 1024 * 1024
CORS(app)  # Biar bisa diakses dari Laravel

registered_faces = {}  # Simulasi DB sementara

@app.route('/register', methods=['POST'])
def register_face():

    if 'photo' not in request.files or 'name' not in request.form:
        return jsonify({'Form Keys: ': list(request.form.keys()),
                        'Form Data:': dict(request.form),
                        'Form Keys:': list(request.files.keys())}), 400

    name = request.form['name']
    file = request.files['photo']

    try:
        image = face_recognition.load_image_file(file)
        encodings = face_recognition.face_encodings(image)

        if len(encodings) == 0:
            return jsonify({'error': 'Tidak ditemukan wajah dalam gambar'}), 400

        encoding_array = encodings[0]
        encoding_str = ','.join([str(x) for x in encoding_array])
        registered_faces[name] = encoding_str

        return jsonify({'message': 'Wajah berhasil diregistrasi', 'encoding': encoding_str})

    except Exception as e:
        return jsonify({'error': f'Gagal memproses gambar: {str(e)}'}), 500


@app.route('/recognize', methods=['POST'])
def recognize_face():
    if 'photo' not in request.files:
        return jsonify({'error': 'Foto wajib diisi'}), 400

    file = request.files['photo']

    try:
        # Load gambar dari file
        image = face_recognition.load_image_file(file)
        encodings = face_recognition.face_encodings(image)

        if len(encodings) == 0:
            return jsonify({'error': 'Tidak ditemukan wajah dalam gambar. Pastikan pencahayaan cukup dan wajah menghadap kamera.'}), 400

        unknown_encoding = encodings[0]

        # Ambil data user dari Laravel
        response = requests.get('http://franken:8002/api/user-data')

        if response.status_code != 200:
            return jsonify({'error': f'Respon Laravel gagal dengan kode {response.status_code}'}), 500

        try:
            json_data = response.json()
        except Exception as e:
            return jsonify({'error': f'Respons bukan JSON valid: {str(e)}'}), 500

        faces = json_data.get('data', [])
        if not isinstance(faces, list):
            return jsonify({'error': 'Data wajah dari Laravel tidak dalam format list'}), 500

        errors = []  # Untuk mencatat log per banding wajah

        for face in faces:
            try:
                if not isinstance(face, dict):
                    errors.append('Format wajah bukan dict')
                    continue

                encoding_str = face.get('face_encoding')
                name = face.get('nama')

                if not encoding_str or not name:
                    errors.append(f'Encoding atau nama kosong: {face}')
                    continue

                # Bersihkan encoding string
                encoding_str = (
                    encoding_str
                    .replace('"', '')
                    .replace("'", '')
                    .replace('\\', '')
                    .strip()
                )

                # Ubah string ke numpy array
                known_encoding = np.fromstring(encoding_str, sep=',')

                if known_encoding.size != 128:
                    errors.append(f'Encoding tidak valid, panjangnya: {known_encoding.size}')
                    continue

                # Bandingkan wajah
                match = face_recognition.compare_faces([known_encoding], unknown_encoding, tolerance=0.5)

                if match[0]:
                    return jsonify({'name': name})

            except Exception as e:
                errors.append(f'Error saat membandingkan wajah: {str(e)}')
                continue

        # Kalau semua wajah tidak cocok
        return jsonify({
            'error': 'Wajah tidak cocok dengan data yang terdaftar.',
            'log': errors
        }), 404

    except Exception as e:
        return jsonify({'error': f'Terjadi kesalahan server: {str(e)}'}), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True,use_reloader=False)
