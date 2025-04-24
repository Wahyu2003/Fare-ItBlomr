<?php

namespace App\Http\Controllers;

use App\Models\Ortu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class OrtuController extends Controller
{
    public function index()
    {
        $ortu = Ortu::all();
        return view('ortu.index', compact('ortu'));
    }

    public function create()
    {
        return view('ortu.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'min:8'],
            'username' => ['required', 'string', 'min:8', 'lowercase', 'unique:ortu,username'],
            'password' => ['required', 'string', 'min:8'],
            'no_hp' => ['required', 'string', 'min:11', 'max:13'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Ortu::create($validator->validated());
        return redirect()->route('ortu.index')->with('success', 'Orang Tua berhasil ditambahkan');
    }

    public function show(Ortu $ortu)
    {
        return view('ortu.show', compact('ortu'));
    }

    public function edit(Ortu $ortu)
    {
        return view('ortu.edit', compact('ortu'));
    }

    public function update(Request $request, Ortu $ortu)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'min:8'],
            'username' => ['required', 'string', 'min:8', 'lowercase', 'unique:ortu,username,' . $ortu->id_ortu . ',id_ortu'],
            'password' => ['required', 'string', 'min:8'],
            'no_hp' => ['required', 'string', 'min:11', 'max:13'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ortu->update($validator->validated());
        return redirect()->route('ortu.index')->with('success', 'Orang Tua berhasil diubah');
    }

    public function destroy(Ortu $ortu)
    {
        $ortu->delete();
        return redirect()->route('ortu.index')->with('success', 'Orang Tua berhasil dihapus');
    }
}