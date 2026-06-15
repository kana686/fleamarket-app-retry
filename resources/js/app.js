import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.querySelector('.menu-toggle');
    const mobileNav = document.querySelector('.mobile-nav');

    if (toggleBtn && mobileNav) {
        toggleBtn.addEventListener('click', () => {
            mobileNav.classList.toggle('is-open');
        });
    }
});