document.getElementById('picture').addEventListener('change', function(event) {
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            // Ändert das src des Bildes zur Vorschau
            document.getElementById('preview_image').src = e.target.result;
        }

        reader.readAsDataURL(file); // Liest das Bild lokal ein
    }
});