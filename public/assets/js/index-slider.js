// Testimonials slider. Safe to load on every page: it does nothing when the
// page has no `.mySlides` elements. `plusSlides` / `currentSlides` stay global
// because the Blade markup calls them from inline `onclick` attributes.
let slideIndex = 1;

function getSlides() {
    return document.getElementsByClassName('mySlides');
}

function showSlides(n) {
    const slides = getSlides();

    if (slides.length === 0) {
        return;
    }

    if (n > slides.length) {
        slideIndex = 1;
    }

    if (n < 1) {
        slideIndex = slides.length;
    }

    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
    }

    slides[slideIndex - 1].style.display = 'block';
}

function plusSlides(n) {
    showSlides((slideIndex += n));
}

function currentSlides(n) {
    showSlides((slideIndex = n));
}

showSlides(slideIndex);
