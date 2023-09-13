function editIframe(iframe, idInput) {
   let input = document.getElementById(idInput);
   input.addEventListener("change", () => {
      let frame = document.querySelector(iframe);
      if (input.value.startsWith('https://www.youtube.com/')){
         frame.src = input.value.replace('watch?v=', 'embed/');
      }
      if (input.value.startsWith('https://www.dailymotion.com/')){
         frame.src = input.value.replace('https://www.dailymotion.com/', 'https://www.dailymotion.com/embed/');
      }
   });
}