var slideIndex= 1;
    
showSlides(slideIndex)

function plusSlides(n)
{
    showSlides(slideIndex +=n);
}

function currentSlides(n){
    showSlides(slideIndex =n);
}

function showSlides(n)
{
    var i;

    var slides=document.getElementsByClassName('mySlides');
    
    if(n> slides.length)
    {
        slideIndex=1
    }
        
    if(n<1)
    {
        slideIndex=slides.length;
    }
    
    for(i=0; i<slides.length; i++)
    {
        slides[i].style.display="none";
    }
    
    slides[slideIndex-1].style.display="block"
}

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

    // document.addEventListener("click", function (event) {
    //     if (!burgerMenu.contains(event.target) && !burgerIcon.contains(event.target)) {
    //         burgerMenu.classList.remove("active");
    //     }
    // });
});
