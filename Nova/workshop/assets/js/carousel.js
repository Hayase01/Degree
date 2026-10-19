console.log('hello')

const track = document.querySelector('.carousel-track');
const slides = document.querySelectorAll('.slide');

const nextBtn = document.getElementById('suivant');
const prevBtn = document.getElementById('precedent');

let currentSlide = 0;

function updateSlider() {
    track.style.transform =
        `translateX(-${currentSlide * 100}%)`;
}

function nextSlide() {

    currentSlide++;

    if(currentSlide >= slides.length){
        currentSlide = 0;
    }

    updateSlider();
}

function prevSlide() {

    currentSlide--;

    if(currentSlide < 0){
        currentSlide = slides.length - 1;
    }

    updateSlider();
}

nextBtn.addEventListener('click', nextSlide);
prevBtn.addEventListener('click', prevSlide);

setInterval(() => {
    nextSlide();
}, 5000);