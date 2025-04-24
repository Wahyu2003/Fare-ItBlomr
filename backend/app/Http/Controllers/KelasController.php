<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:24',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Kelas::create($validator->validated());
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function show(Kelas $kelas)
    {
        return view('kelas.show', compact('kelas'));
    }

    public function edit(Kelas $kelas)
    {
        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:24',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kelas->update($validator->validated());
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diubah');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}