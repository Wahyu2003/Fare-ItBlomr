// admin-content.js

document.addEventListener('DOMContentLoaded', function () {
    // Pratinjau Unggah File
    const fileInput = document.querySelector('#file-input');
    const filePreview = document.querySelector('#file-preview');

    if (fileInput && filePreview) {
        fileInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    filePreview.innerHTML = `<img src="${e.target.result}" class="student-photo" alt="Foto Siswa">`;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Logika Tombol Switch untuk Beralih Tampilan Siswa/Guru
    try {
        const buttons = document.querySelectorAll('.wajahFlipBtn');
        const pages = document.querySelectorAll('.wajahFlipPage');

        if (!buttons.length || !pages.length) {
            console.error('Elemen tombol atau halaman tidak ditemukan. Pastikan struktur HTML benar.');
            return;
        }

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                if (!this.classList.contains('wajahFlipDisabled')) {
                    const targetId = this.getAttribute('data-target');
                    const targetPage = document.getElementById('wajahFlip' + targetId.charAt(0).toUpperCase() + targetId.slice(1));
                    const currentPage = document.querySelector('.wajahFlipPage.wajahFlipActive');

                    if (!targetPage || !currentPage) {
                        console.error('Halaman target atau halaman aktif tidak ditemukan.');
                        return;
                    }

                    // Sembunyikan halaman saat ini
                    currentPage.classList.remove('wajahFlipActive');

                    // Tampilkan halaman target
                    targetPage.classList.add('wajahFlipActive');

                    // Perbarui status tombol
                    buttons.forEach(btn => {
                        const btnTarget = btn.getAttribute('data-target');
                        if (btnTarget === targetId) {
                            btn.classList.add('wajahFlipDisabled');
                            btn.setAttribute('disabled', 'disabled');
                        } else {
                            btn.classList.remove('wajahFlipDisabled');
                            btn.removeAttribute('disabled');
                        }
                    });
                }
            });
        });
    } catch (error) {
        console.error('Terjadi kesalahan saat menjalankan script:', error);
    }
});