<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('ortu')->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => ['required', 'string'],
            'nama' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:30', 'min:8', 'lowercase', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,guru,siswa'],
            'face_encoding' => ['sometimes'],
            'no_hp' => ['sometimes', 'string', 'min:11', 'max:13'],
            'kelas' => ['sometimes', 'string'],
            'foto' => ['sometimes', 'image', 'max:2048'],
            'id_ortu' => ['sometimes', 'exists:ortu,id_ortu'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        User::create($data);
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
            'nik' => ['required', 'string'],
            'nama' => ['required', 'string', 'max:30'],
            'username' => ['required', 'string', 'max:30', 'min:8', 'lowercase', 'unique:users,username,' . $user->id_user . ',id_user'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,guru,siswa'],
            'face_encoding' => ['sometimes'],
            'no_hp' => ['sometimes', 'string', 'min:11', 'max:13'],
            'kelas' => ['sometimes', 'string'],
            'foto' => ['sometimes', 'image', 'max:2048'],
            'id_ortu' => ['sometimes', 'exists:ortu,id_ortu'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $user->update($data);
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil diubah');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Pengguna berhasil dihapus');
    }
}