function loadImg(img, idInput){
   let image = document.querySelector(img);
   let input = document.getElementById(idInput);
   input.addEventListener("change", () => {
      image.src = URL.createObjectURL(input.files[0]);
   });
}