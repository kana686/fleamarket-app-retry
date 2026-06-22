import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.querySelector('.menu-toggle');
    const mobileNav = document.querySelector('.mobile-nav');

    if (toggleBtn && mobileNav) {
        toggleBtn.addEventListener('click', () => {
            mobileNav.classList.toggle('is-open');
        });
    }

    const imageInput = document.getElementById('profile-image-input');
    const imagePreview = document.getElementById('profile-image-preview');

    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }

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