document.addEventListener('DOMContentLoaded', () => {

    const sellImageInput = document.getElementById('sell-image-input');
    const sellImagePreview = document.getElementById('sell-image-preview');

    if (sellImageInput && sellImagePreview) {
        sellImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    sellImagePreview.src = event.target.result;
                    sellImagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    }
});