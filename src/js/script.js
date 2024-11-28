document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const navLinks = document.querySelector('.links');

    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('show');
    });
});
