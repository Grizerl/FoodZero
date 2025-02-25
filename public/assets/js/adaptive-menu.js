document.addEventListener("DOMContentLoaded", function () {
    const burgerIcon = document.querySelector(".adaptive-icon");
    const closeButton = document.querySelector(".close-btn");
    const burgerMenu = document.querySelector(".burger-menu");

    burgerIcon.addEventListener("click", function () {
        burgerMenu.classList.add("active");
    });

    closeButton.addEventListener("click", function () {
        burgerMenu.classList.remove("active");
    });

    document.addEventListener("click", function (event) {
        if (!burgerMenu.contains(event.target) && !burgerIcon.contains(event.target)) {
            burgerMenu.classList.remove("active");
        }
    });
});