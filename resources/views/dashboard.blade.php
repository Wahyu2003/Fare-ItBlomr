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
                <th>NIS</th>
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
                <td>1234567890</td>
                <td>M. Sholiudin</td>
                <td>10 MM 2</td>
                <td>Hadir</td>
                <td>06:45</td>
                <td>-</td>
            </tr>
        </tbody>
    </table>
@endsection