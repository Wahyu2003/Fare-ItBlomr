@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Jadwal Pelajaran</h1>
    <form action="{{ route('jadwalPelajaran.update', $jadwalPelajaran->id_jadwal_pelajaran) }}" method="POST" class="admin-form">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="hari">Hari</label>
            <select name="hari" id="hari" class="form-control">
                <option value="">Pilih Hari</option>
                <option value="Senin" {{ old('hari', $jadwalPelajaran->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                <option value="Selasa" {{ old('hari', $jadwalPelajaran->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                <option value="Rabu" {{ old('hari', $jadwalPelajaran->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                <option value="Kamis" {{ old('hari', $jadwalPelajaran->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                <option value="Jumat" {{ old('hari', $jadwalPelajaran->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                <option value="Sabtu" {{ old('hari', $jadwalPelajaran->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                <option value="Minggu" {{ old('hari', $jadwalPelajaran->hari) == 'Minggu' ? 'selected' : '' }}>Minggu</option>
            </select>
            @error('hari')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ old('jam_mulai', $jadwalPelajaran->jam_mulai) }}">
            @error('jam_mulai')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="jam_selesai">Jam Selesai</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ old('jam_selesai', $jadwalPelajaran->jam_selesai) }}">
            @error('jam_selesai')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="kelas">Kelas</label>
            <select name="kelas" id="kelas" class="form-control">
                <option value="">Pilih Kelas</option>
                <option value="10" {{ old('kelas', $jadwalPelajaran->kelas) == '10' ? 'selected' : '' }}>10</option>
                <option value="11" {{ old('kelas', $jadwalPelajaran->kelas) == '11' ? 'selected' : '' }}>11</option>
                <option value="12" {{ old('kelas', $jadwalPelajaran->kelas) == '12' ? 'selected' : '' }}>12</option>
            </select>
            @error('kelas')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="multimedia">Multimedia</label>
            <select name="multimedia" id="multimedia" class="form-control">
                <option value="">Pilih Multimedia</option>
                <option value="Multimedia 1" {{ old('multimedia', $jadwalPelajaran->multimedia) == 'Multimedia 1' ? 'selected' : '' }}>Multimedia 1</option>
                <option value="Multimedia 2" {{ old('multimedia', $jadwalPelajaran->multimedia) == 'Multimedia 2' ? 'selected' : '' }}>Multimedia 2</option>
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
                </select>
                <button type="button" class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#addMataPelajaranModal">Tambah Mata Pelajaran</button>
            </div>
            @error('id_mata_pelajaran')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    <!-- Modal untuk Tambah Mata Pelajaran -->
    <div class="modal fade" id="addMataPelajaranModal" tabindex="-1" aria-labelledby="addMataPelajaranModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMataPelajaranModalLabel">Tambah Mata Pelajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addMataPelajaranForm" class="admin-form">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_mata_pelajaran_modal">Nama Mata Pelajaran</label>
                            <input type="text" name="nama_mata_pelajaran" id="nama_mata_pelajaran_modal" class="form-control" value="{{ old('nama_mata_pelajaran') }}">
                            <span class="text-danger" id="nama_mata_pelajaran_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="kelas_modal">Kelas</label>
                            <select name="kelas" id="kelas_modal" class="form-control">
                                <option value="10" {{ old('kelas') == '10' ? 'selected' : '' }}>10</option>
                                <option value="11" {{ old('kelas') == '11' ? 'selected' : '' }}>11</option>
                                <option value="12" {{ old('kelas') == '12' ? 'selected' : '' }}>12</option>
                            </select>
                            <span class="text-danger" id="kelas_error"></span>
                        </div>
                        <div class="mb-3">
                            <label for="multimedia_modal">Multimedia</label>
                            <select name="multimedia" id="multimedia_modal" class="form-control">
                                <option value="Multimedia 1" {{ old('multimedia') == 'Multimedia 1' ? 'selected' : '' }}>Multimedia 1</option>
                                <option value="Multimedia 2" {{ old('multimedia') == 'Multimedia 2' ? 'selected' : '' }}>Multimedia 2</option>
                            </select>
                            <span class="text-danger" id="multimedia_error"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Hapus Mata Pelajaran -->
    <div class="modal fade" id="deleteMataPelajaranModal" tabindex="-1" aria-labelledby="deleteMataPelajaranModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteMataPelajaranModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus mata pelajaran ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Fungsi untuk refresh dropdown mata pelajaran
    function refreshMataPelajaran() {
        $.get('{{ route("mataPelajaran.get") }}', function(data) {
            const mataPelajaranSelect = $('#id_mata_pelajaran');
            mataPelajaranSelect.empty();
            mataPelajaranSelect.append('<option value="">Pilih Mata Pelajaran</option>');
            data.forEach(mp => {
                mataPelajaranSelect.append(
                    `<option value="${mp.id_mata_pelajaran}" data-kelas="${mp.kelas}" data-multimedia="${mp.multimedia}">
                        ${mp.nama_mata_pelajaran} (Kelas ${mp.kelas} - ${mp.multimedia})
                    </option>`
                );
            });
            filterMataPelajaran(); // Terapkan filter setelah refresh
            // Pilih kembali opsi yang sebelumnya dipilih
            const selectedId = '{{ old("id_mata_pelajaran", $jadwalPelajaran->id_mata_pelajaran) }}';
            if (selectedId) {
                mataPelajaranSelect.val(selectedId);
            }
        });
    }

    // Tambah mata pelajaran via AJAX
    $('#addMataPelajaranForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();
        $.ajax({
            url: '{{ route("mataPelajaran.store") }}', // Gunakan rute yang benar
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#addMataPelajaranModal').modal('hide');
                    refreshMataPelajaran();
                    $('#addMataPelajaranForm')[0].reset();
                    $('#nama_mata_pelajaran_error').text('');
                    $('#kelas_error').text('');
                    $('#multimedia_error').text('');
                } else {
                    alert('Gagal menambah mata pelajaran. Silakan coba lagi.');
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                $('#nama_mata_pelajaran_error').text(errors?.nama_mata_pelajaran ? errors.nama_mata_pelajaran[0] : '');
                $('#kelas_error').text(errors?.kelas ? errors.kelas[0] : '');
                $('#multimedia_error').text(errors?.multimedia ? errors.multimedia[0] : '');
                console.log(xhr.responseText); // Tambahkan untuk debugging
            }
        });
    });

    // Hapus mata pelajaran via AJAX
    let deleteId = null;
    $('#id_mata_pelajaran').on('change', function() {
        deleteId = $(this).val();
        if (deleteId) {
            $('#deleteMataPelajaranModal').modal('show');
        }
    });

    $('#confirmDelete').on('click', function() {
        if (deleteId) {
            $.ajax({
                url: '{{ route("mataPelajaran.destroy", ":id") }}'.replace(':id', deleteId),
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#deleteMataPelajaranModal').modal('hide');
                        refreshMataPelajaran();
                        $('#id_mata_pelajaran').val(''); // Reset pilihan setelah hapus
                        deleteId = null;
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // Tambahkan untuk debugging
                }
            });
        }
    });

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

    // Event listener untuk kelas dan multimedia
    $('#kelas, #multimedia').on('change', function() {
        filterMataPelajaran();
    });

    // Inisialisasi refresh pertama kali
    refreshMataPelajaran();
});
</script>
<style>
.mata-pelajaran-container {
    position: relative;
}
</style>
@endsection