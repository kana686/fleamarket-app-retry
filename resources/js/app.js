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
                    if (imagePreview.tagName === 'DIV') {
                        const img = document.createElement('img');
                        img.id = 'profile-image-preview';
                        img.className = imagePreview.className;
                        imagePreview.parentNode.replaceChild(img, imagePreview);

                        const newPreview = document.getElementById('profile-image-preview');
                        newPreview.src = e.target.result;
                    } else {
                        imagePreview.src = e.target.result;
                    }
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

    const input = document.getElementById('price-input');

    if (input) {
        input.addEventListener('blur', function () {
            let value = this.value.replace(/,/g, '');
            
            if (!isNaN(value) && value !== "") {
                this.value = Number(value).toLocaleString();
            }
        });

        input.addEventListener('focus', function () {
            this.value = this.value.replace(/,/g, '');
        });
    }
});