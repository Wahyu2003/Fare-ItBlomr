<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        if ($user->role == 'admin') {
            return view('profile.edit_admin', compact('user'));
        } elseif ($user->role == 'siswa') {
            return view('profile.edit_siswa', compact('user'));
        } elseif ($user->role == 'guru') {
            return view('profile.edit_admin', compact('user'));
        } else {
            abort(403);
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin tidak perlu field khusus siswa
            $rules = [
                'nama' => 'required|string|max:255',
                'password' => 'nullable|string|min:6|confirmed',
                'foto' => 'nullable|image|max:2048',
            ];
        } elseif ($user->role === 'guru') {
            $rules = [
                'nama' => 'required|string|max:255',
                'password' => 'nullable|string|min:6|confirmed',
                'foto' => 'nullable|image|max:2048',
            ];
        } elseif ($user->role === 'siswa') {
            // Siswa perlu validasi field tambahan
            $rules = [
                'nama' => 'required|string|max:255',
                'no_hp_siswa' => 'nullable|string|max:20',
                'nama_ortu' => 'nullable|string|max:255',
                'no_hp_ortu' => 'nullable|string|max:20',
                'password' => 'nullable|string|min:6|confirmed',
                'foto' => 'nullable|image|max:2048',
            ];
        } else {
            abort(403);
        }

        $validated = $request->validate($rules);

        $user->nama = $validated['nama'];

        if ($user->role === 'siswa') {
            // Update field khusus siswa
            $user->no_hp_siswa = $validated['no_hp_siswa'] ?? $user->no_hp_siswa;
            $user->nama_ortu = $validated['nama_ortu'] ?? $user->nama_ortu;
            $user->no_hp_ortu = $validated['no_hp_ortu'] ?? $user->no_hp_ortu;
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_images', $filename);

            if ($user->foto && \Storage::exists('public/profile_images/' . $user->foto)) {
                \Storage::delete('public/profile_images/' . $user->foto);
            }

            $user->foto = $filename;
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    public function ambilfoto(Request $request)
    {
        $user = Auth::user();
        $fotoPath = 'storage/profile_images/' . $user->foto;

        if (\Storage::exists($fotoPath)) {
            return response()->file(\Storage::path($fotoPath));
        } else {
            abort(404);
        }
        // The following line seems unnecessary and unreachable, consider removing it
        // return redirect(layouts.admin)
    }
}
