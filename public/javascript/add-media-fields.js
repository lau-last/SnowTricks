function loadImg(img, idInput) {
    let buttonAdd = document.querySelector('#add-picture');
    let input = document.getElementById(idInput);
    input.addEventListener("change", () => {
        let image = document.querySelector(img);
        image.src = URL.createObjectURL(input.files[0]);
        buttonAdd.disabled = false;
    });
}

function loadIframe(iframe, idInput) {
    let buttonAdd = document.querySelector('#add-video');
    let input = document.getElementById(idInput);
    input.addEventListener("change", () => {
        let frame = document.querySelector(iframe);
        if (input.value.startsWith('https://www.youtube.com/')){
            frame.src = input.value.replace('watch?v=', 'embed/');
        }
        if (input.value.startsWith('https://www.dailymotion.com/')){
            frame.src = input.value.replace('https://www.dailymotion.com/', 'https://www.dailymotion.com/embed/');
        }
        buttonAdd.disabled = false;
    });
}

function createFrame(selector, index, tagName, className) {
    let div = document.querySelector(selector + index)
    let frame = document.createElement(tagName);
    frame.src = "";
    frame.className = className + index;
    div.append(frame);
}

function createButtonSupp(selector, index, text, buttonSelector) {
    let div = document.querySelector(selector + index)
    let buttonSupp = document.createElement("button");
    buttonSupp.type = "button";
    buttonSupp.className = "mt-3 btn btn-danger d-flex delete-" + index;
    buttonSupp.textContent = text;
    div.append(buttonSupp);
    buttonSupp.addEventListener("click", function () {
        let buttonAdd = document.querySelector(buttonSelector);
        buttonAdd.disabled = false;
        this.previousElementSibling.parentElement.parentElement.remove();
    });
}

function addFieldPicture() {
    let divPicture = document.querySelector('#pictures');
    let prototype = divPicture.dataset.prototype;
    let index = document.querySelectorAll(".picture-fields").length;
    prototype = prototype.replace(/__name__/g, index);
    divPicture.insertAdjacentHTML("beforeend", prototype);
    loadImg("img.img-" + index + "", "trick_pictures_" + index + "_file");
}

function addFieldVideo() {
    let divVideo = document.querySelector('#videos');
    let prototype = divVideo.dataset.prototype;
    let index = document.querySelectorAll(".video-fields").length;
    prototype = prototype.replace(/__name__/g, index);
    divVideo.insertAdjacentHTML("beforeend", prototype);
    loadIframe("iframe.iframe-" + index + "", "trick_videos_" + index + "_url")
}

