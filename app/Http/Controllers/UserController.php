<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Import Hash
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Mengambil semua data pengguna tanpa relasi
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => ['required', 'string', 'max:20'],
            'nama' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:30', 'min:8', 'lowercase', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,siswa'], // Role hanya admin dan siswa
            'face_encoding' => ['nullable'], // Nullable, tidak wajib
            'no_hp_siswa' => ['nullable', 'string', 'min:11', 'max:13'],
            'kelas' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'], // Tidak wajib
            'nama_ortu' => ['nullable', 'string', 'max:100'], // Kolom nama orang tua
            'no_hp_ortu' => ['nullable', 'string', 'min:11', 'max:13'], // Kolom no hp orang tua
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        // Mengenkripsi password sebelum menyimpannya
        $data['password'] = Hash::make($request->password);

        // Jika ada file foto, simpan di storage
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fotos', 'public'); // Menyimpan gambar dengan nama unik
        }

        User::create($data); // Menyimpan data pengguna baru
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'nik' => ['required', 'string', 'max:20'],
            'nama' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:30', 'min:8', 'lowercase', 'unique:users,username,' . $user->id_user . ',id_user'],
            'password' => ['nullable', 'string', 'min:8'], // Password bersifat opsional pada update
            'role' => ['required', 'in:admin,siswa'], // Role hanya admin dan siswa
            'face_encoding' => ['nullable'],
            'no_hp_siswa' => ['nullable', 'string', 'min:11', 'max:13'],
            'kelas' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'nama_ortu' => ['nullable', 'string', 'max:100'],
            'no_hp_ortu' => ['nullable', 'string', 'min:11', 'max:13'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput(); // Mengembalikan input yang sudah dimasukkan
        }
        $data = $validator->validated(); // Mengambil data yang tervalidasi
    
        // Jika password baru diisi, maka update password
        if ($request->has('password') && $request->password !== '') {
            $data['password'] = Hash::make($request->password); // Mengenkripsi password jika diisi
        }
    
        // Jika ada foto baru yang diunggah, simpan foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama dari storage jika ada
            if ($user->foto) {
                // Cek apakah file lama ada di folder penyimpanan sebelum menghapus
                $oldFilePath = storage_path('app/public/' . $user->foto);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath); // Menghapus foto lama
                }
            }
            // Simpan foto baru
            $data['foto'] = $request->file('foto')->store('fotos', 'public'); // Menyimpan foto baru di folder 'public/fotos'
        }
        // Update data pengguna
        $user->update($data);
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil diubah');
    }
    
    public function destroy(User $user)
    {
        // Hapus foto jika ada
        if ($user->foto) {
            unlink(storage_path('app/public/' . $user->foto)); // Menghapus foto dari storage
        }

        $user->delete(); // Menghapus pengguna dari database
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus');
    }
}