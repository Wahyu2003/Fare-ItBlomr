<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Kelas;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        // Mengambil data kelas
        $kelas = Kelas::all(); // Ambil semua data kelas

        // Passing data kelas ke view 'user.create'
        return view('user.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nik' => ['required', 'string', 'max:20'],
            'nama' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:30', 'min:8', 'lowercase', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,siswa,guru'],
            'face_encoding' => ['nullable'],
            'no_hp_siswa' => ['nullable', 'string', 'max:13'],
            'kelas' => ['nullable', 'in:10,11,12'],
            'multimedia' => ['nullable', 'in:Multimedia 1,Multimedia 2'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'nama_ortu' => ['nullable', 'string', 'max:100'],
            'no_hp_ortu' => ['nullable', 'string', 'max:13'],
        ];

        if ($request->role == 'siswa') {
            $rules['nama_ortu'] = ['required', 'string', 'max:100'];
            $rules['no_hp_siswa'] = ['required', 'string', 'max:13'];
            $rules['kelas'] = ['required', 'in:10,11,12'];
            $rules['multimedia'] = ['required', 'in:Multimedia 1,Multimedia 2'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            \Log::error('Validation failed on store: ' . json_encode($validator->errors()));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $data['password'] = Hash::make($request->password);

        if ($request->role == 'siswa') {
            $data['kelas'] = $data['kelas'] . ' - ' . $data['multimedia'];
            unset($data['multimedia']);
        }

        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $data['foto'] = $photo->store('fotos', 'public');

            $response = Http::attach(
                'photo', file_get_contents($photo), $photo->getClientOriginalName()
            )->post('http://faceapi:5000/register', [
                'name' => $request->nama,
            ]);

            if ($response->successful()) {
                $encoding = $response->json()['encoding'];
                $data['face_encoding'] = json_encode($encoding);
            } else {
                \Log::error('FaceAPI Error: ' . $response->body());
                return redirect()->back()->with('error', 'Gagal memproses wajah. Wajah Kurang Jelas')->withInput();
            }
        }

        try {
            User::create($data);
            return redirect()->route('user.index')->with('success', 'Pengguna berhasil ditambahkan');
        } catch (\Exception $e) {
            \Log::error('Failed to save user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage())->withInput();
        }
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        if ($user->role == 'guru') {
            return view('user.edit_guru', compact('user'));
        }
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'nik' => ['required', 'string', 'max:20'],
            'nama' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:30', 'min:8', 'lowercase', 'unique:users,username,' . $user->id_user . ',id_user'],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'in:admin,siswa,guru'],
            'face_encoding' => ['nullable'],
            'no_hp_siswa' => ['nullable', 'string', 'max:13'],
            'kelas' => ['nullable', 'in:10,11,12'],
            'multimedia' => ['nullable', 'in:Multimedia 1,Multimedia 2'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'nama_ortu' => ['nullable', 'string', 'max:100'],
            'no_hp_ortu' => ['nullable', 'string', 'max:13'],
        ];

        if ($request->role == 'siswa') {
            $rules['nama_ortu'] = ['required', 'string', 'max:100'];
            $rules['no_hp_siswa'] = ['required', 'string', 'max:13'];
            $rules['kelas'] = ['required', 'in:10,11,12'];
            $rules['multimedia'] = ['required', 'in:Multimedia 1,Multimedia 2'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            \Log::error('Validation failed on update: ' . json_encode($validator->errors()));
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if ($request->has('password') && $request->password !== '') {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->role == 'siswa') {
            $data['kelas'] = $data['kelas'] . ' - ' . $data['multimedia'];
            unset($data['multimedia']);
        } else {
            $data['kelas'] = $user->kelas;
            $data['nama_ortu'] = null;
            $data['no_hp_ortu'] = null;
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                $oldFilePath = storage_path('app/public/' . $user->foto);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        try {
            $user->update($data);
            return redirect()->route('user.index')->with('success', 'Pengguna berhasil diubah');
        } catch (\Exception $e) {
            \Log::error('Failed to update user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengubah pengguna: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->foto) {
                $oldFilePath = storage_path('app/public/' . $user->foto);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $user->delete();
            return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus');
        } catch (\Exception $e) {
            \Log::error('Failed to delete user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }
}
