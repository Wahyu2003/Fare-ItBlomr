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

        # Simulasi simpan ke DB
        registered_faces[name] = encoding_str

        # Kamu bisa simpan encoding_str ke DB Laravel pakai request POST ke API Laravel
        # requests.post("http://localhost:8000/api/save-encoding", data={"name": name, "encoding": encoding_str})

        return jsonify({'message': 'Wajah berhasil diregistrasi', 'encoding': encoding_str})

    except Exception as e:
        return jsonify({'error': f'Gagal memproses gambar: {str(e)}'}), 500


@app.route('/recognize', methods=['POST'])
def recognize_face():
    if 'photo' not in request.files:
        return jsonify({'error': 'Foto wajib diisi'}), 400

    file = request.files['photo']
    image = face_recognition.load_image_file(file)
    encodings = face_recognition.face_encodings(image)

    if len(encodings) == 0:
        return jsonify({'error': 'Tidak ditemukan wajah dalam gambar'}), 400

    unknown_encoding = encodings[0]

    try:
        response = requests.get('http://laravel_franken:8001/api/user-data')

        if response.status_code != 200:
            return jsonify({'error': f'Respon Laravel gagal dengan kode {response.status_code}'}), 500

        try:
            json_data = response.json()
        except Exception as e:
            return jsonify({'error': f'Respons bukan JSON valid: {str(e)}'}), 500

        faces = json_data.get('data', [])
        if not isinstance(faces, list):
            return jsonify({'error': 'Data wajah dari Laravel tidak dalam format list'}), 500

        errors = []  # <- Simpan error per wajah

        for face in faces:
            try:
                if not isinstance(face, dict):
                    errors.append('Format wajah bukan dict')
                    continue

                encoding_str = face.get('encoding')
                name = face.get('name')

                if not encoding_str or not name:
                    errors.append(f'Encoding atau nama kosong: {face}')
                    continue

                encoding_str = (
                    encoding_str
                    .replace('"', '')
                    .replace("'", '')
                    .replace('\\', '')
                    .strip()
                )

                known_encoding = np.fromstring(encoding_str, sep=',')

                if known_encoding.size != 128:
                    errors.append(f'Encoding tidak valid panjangnya: {known_encoding.size}')
                    continue

                match = face_recognition.compare_faces([known_encoding], unknown_encoding, tolerance=0.5)

                if match[0]:
                    return jsonify({'name': name})

            except Exception as e:
                errors.append(f'Error saat membandingkan wajah: {str(e)}')
                continue

        # Jika tidak cocok semua
        return jsonify({
            'error': 'Wajah tidak cocok',
            'log': errors
        }), 404

    except Exception as e:
        return jsonify({'error': f'Gagal mengambil data wajah: {str(e)}'}), 500
# def recognize_face():
#     if 'photo' not in request.files:
#         return jsonify({'error': 'Foto wajib diisi'}), 400

#     file = request.files['photo']
#     image = face_recognition.load_image_file(file)
#     encodings = face_recognition.face_encodings(image)

#     if len(encodings) == 0:
#         return jsonify({'error': 'Tidak ditemukan wajah dalam gambar'}), 400

#     unknown_encoding = encodings[0]

#     # Ambil data encoding dari Laravel
#     try:
#         response = requests.get('http://laravel_franken:8001/api/user-data')
        
#         # Pastikan respons valid dan JSON
#         if response.status_code != 200:
#             return jsonify({'error': f'Respon Laravel gagal dengan kode {response.status_code}'}), 500

#         try:
#             json_data = response.json()  # Coba konversi ke JSON
#         except Exception as e:
#             return jsonify({'error': f'Respons bukan JSON valid: {str(e)}'}), 500
        
#         # Cek apakah respons memiliki key 'data' dan 'faces' dalam format yang benar
#         faces = json_data.get('data', [])  # Mengambil data dari key 'data'

#         # Validasi struktur data JSON yang diterima
#         if not isinstance(faces, list):
#             return jsonify({'error': 'Data wajah dari Laravel tidak dalam format list'}), 500

#         # Loop untuk membandingkan wajah
#         for face in faces:
#             try:
#                 encoding_str = face.get('encoding')
#                 name = face.get('name')

#                 if not encoding_str or not name:
#                     continue

#                 encoding_str = (
#                     encoding_str
#                     .replace('"', '')
#                     .replace("'", '')
#                     .replace('\\', '')
#                     .strip()
#                 )

#                 known_encoding = np.fromstring(encoding_str, sep=',')
#                 match = face_recognition.compare_faces([known_encoding], unknown_encoding, tolerance=0.75)

#                 if not match[0]:
#                     return jsonify({'name': name})
#             except Exception as e:
#                 return jsonify({'error': f'Tidak Match: {str(e)}'})

#         return jsonify({'error': 'Wajah tidak cocok'}), 404

#     except Exception as e:
#         return jsonify({'error': f'Gagal mengambil data wajah: {str(e)}'}), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True,use_reloader=False)
