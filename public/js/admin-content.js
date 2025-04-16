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
});