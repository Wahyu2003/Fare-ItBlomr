@extends('layouts.admin')

@section('content')
    <h2>Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="admin-card">
                <h3>36</h3>
                <p>Jumlah Siswa Hadir</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-card">
                <h3>36</h3>
                <p>Total Siswa</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-card">
                <h3>36</h3>
                <p>Terdeteksi Wajah</p>
            </div>
        </div>
    </div>

    <h3>Data Siswa</h3>
    <table class="admin-table">
        <thead>
            <tr>
                <th>NIK</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Waktu</th>
                <th>Bukti Hadir</th>
            </tr>
        </thead>
        <tbody>
            <!-- Placeholder untuk data dinamis -->
            <tr>
                <td>Kolom 1</td>
                <td>Kolom 2</td>
                <td>Kolom 3</td>
                <td>Kolom 4</td>
                <td>Kolom 5</td>
                <td>Kolom 6</td>
            </tr>
        </tbody>
    </table>
@endsection