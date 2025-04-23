<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class FirebaseService
{
    protected $database;

    public function __construct()
    {
        $this->database = (new Factory())
            ->withServiceAccount(storage_path('app/firebase/webfacerecog-firebase-adminsdk-fbsvc-84e491dde6.json'))
            // Menambahkan URL database yang benar
            ->withDatabaseUri('https://webfacerecog-default-rtdb.asia-southeast1.firebasedatabase.app/')
            ->createDatabase();  // Membuat instance Realtime Database
    }

    public function storeJadwal($id, $data)
    {
        // Menyimpan data jadwal ke Firebase
        $this->database->getReference('jadwal_bel/' . $id)->set($data);
    }

    public function deleteJadwal($id)
    {
        // Menghapus data jadwal dari Firebase
        $this->database->getReference('jadwal_bel/' . $id)->remove();
    }
}