<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Models\User;
use Illuminate\Http\Request;

class DataUserController extends Controller
{
    public function index()
    {
        $get = User::all();

        if ($get->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data pengguna'], 404);
        }

        return new DataResource(true, 'user_data', $get);
    }
}
