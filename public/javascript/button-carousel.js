document.addEventListener("DOMContentLoaded", function() {

    let button = document.getElementById("buttonShowCarousel");
    let collapse = document.getElementById("collapseCarousel");
    let widthStart = window.innerWidth;

    if (widthStart > 700){
        button.style.display = "none";
        collapse.classList.add("show");
    }

    window.addEventListener("resize",()=>{
        let width = window.innerWidth;
        if (width > 700){
            button.style.display = "none";
            collapse.classList.add("show");
        } else if (width < 700){
            button.style.display = "block";
            collapse.classList.remove("show");
        }
    });

});