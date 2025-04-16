<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PresensiController extends Controller
{
    public function index()
    {
        $presensi = Presensi::with('kelas')->get();
        return view('presensi.index', compact('presensi'));
    }

    public function create()
    {
        return view('presensi.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hari' => ['required', 'date'],
            'jam_mulai' => ['required'],
            'jam_selesai' => ['required'],
            'id_kelas' => ['required', 'exists:kelas,id_kelas'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Presensi::create($validator->validated());
        return redirect()->route('presensi.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function show(Presensi $presensi)
    {
        return view('presensi.show', compact('presensi'));
    }

    public function edit(Presensi $presensi)
    {
        return view('presensi.edit', compact('presensi'));
    }

    public function update(Request $request, Presensi $presensi)
    {
        $validator = Validator::make($request->all(), [
            'hari' => ['required', 'date'],
            'jam_mulai' => ['required'],
            'jam_selesai' => ['required'],
            'id_kelas' => ['required', 'exists:kelas,id_kelas'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $presensi->update($validator->validated());
        return redirect()->route('presensi.index')->with('success', 'Jadwal berhasil diubah');
    }

    public function destroy(Presensi $presensi)
    {
        $presensi->delete();
        return redirect()->route('presensi.index')->with('success', 'Jadwal berhasil dihapus');
    }
}