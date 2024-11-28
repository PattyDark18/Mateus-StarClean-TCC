// scripts.js
let slideIndex = 0;

function showSlide(index) {
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;
    
    if (index >= totalSlides) slideIndex = 0;
    if (index < 0) slideIndex = totalSlides - 1;

    const slideWidth = slides[0].offsetWidth;
    const slidesContainer = document.querySelector('.slides');

    slidesContainer.style.transform = `translateX(-${slideWidth * slideIndex}px)`;
}

function nextSlide() {
    slideIndex++;
    showSlide(slideIndex);
}

function prevSlide() {
    slideIndex--;
    showSlide(slideIndex);
}

showSlide(slideIndex);


setInterval(nextSlide, 5000);
