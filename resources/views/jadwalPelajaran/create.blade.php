@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Tambah Jadwal Pelajaran</h1>
    <form action="{{ route('jadwalPelajaran.store') }}" method="POST" class="admin-form">
        @csrf
        <div class="mb-3">
            <label for="hari">Hari</label>
            <select name="hari" id="hari" class="form-control">
                <option value="">Pilih Hari</option>
                <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
            </select>
            @error('hari')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai') }}">
            @error('jam_mulai')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai') }}">
            @error('jam_selesai')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="kelas">Kelas</label>
            <select name="kelas" id="kelas" class="form-control">
                <option value="">Pilih Kelas</option>
                <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>10</option>
                <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>11</option>
                <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>12</option>
            </select>
            @error('kelas')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="multimedia">Multimedia</label>
            <select name="multimedia" id="multimedia" class="form-control">
                <option value="">Pilih Multimedia</option>
                <option value="Multimedia 1" {{ old('multimedia') == 'Multimedia 1' ? 'selected' : '' }}>Multimedia 1</option>
                <option value="Multimedia 2" {{ old('multimedia') == 'Multimedia 2' ? 'selected' : '' }}>Multimedia 2</option>
            </select>
            @error('multimedia')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="id_mata_pelajaran">Mata Pelajaran</label>
            <div class="mata-pelajaran-container">
                <select name="id_mata_pelajaran" id="id_mata_pelajaran" class="form-control">
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($mataPelajaran as $mp)
                        <option value="{{ $mp->id_mata_pelajaran }}" data-kelas="{{ $mp->kelas }}" data-multimedia="{{ $mp->multimedia }}">
                            {{ $mp->nama_mata_pelajaran }} (Kelas {{ $mp->kelas }} - {{ $mp->multimedia }})
                        </option>
                    @endforeach
                </select>
                <a href="{{ route('mataPelajaran.add') }}" class="btn btn-sm btn-primary mt-2">Tambah Mata Pelajaran</a>
            </div>
            @error('id_mata_pelajaran')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>

<script>
$(document).ready(function() {
    // Filter mata pelajaran berdasarkan kelas dan multimedia
    function filterMataPelajaran() {
        const kelas = $('#kelas').val();
        const multimedia = $('#multimedia').val();
        const mataPelajaranSelect = $('#id_mata_pelajaran');
        const options = mataPelajaranSelect.find('option');

        options.each(function() {
            const option = $(this);
            const optionKelas = option.data('kelas');
            const optionMultimedia = option.data('multimedia');

            if (option.val() === '') {
                return;
            }

            if (kelas && multimedia) {
                if (optionKelas === kelas && optionMultimedia === multimedia) {
                    option.show();
                } else {
                    option.hide();
                }
            } else {
                option.hide();
            }
        });

        const selectedOption = mataPelajaranSelect.find(':selected');
        if (selectedOption.length && selectedOption.is(':hidden')) {
            mataPelajaranSelect.val('');
        }
    }

    $('#kelas, #multimedia').on('change', function() {
        filterMataPelajaran();
    });

    filterMataPelajaran(); // Inisialisasi filter
});
</script>

<style>
.mata-pelajaran-container {
    position: relative;
}
</style>
@endsection