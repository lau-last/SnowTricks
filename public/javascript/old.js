const createHtmlButtonSupp = (pictureIndex) => {
    let pictureButtonSupp = document.createElement("button");
    pictureButtonSupp.type = "button";
    pictureButtonSupp.className = "btn btn-danger d-flex";
    pictureButtonSupp.id = "delete-picture-" + pictureIndex;
    pictureButtonSupp.innerText = "Supprimer";

    pictureButtonSupp.addEventListener("click", function () {
        this.previousElementSibling.parentElement.remove();
    });

    return pictureButtonSupp;
}

function loadImg(img, idInput, newPictureForm, pictureImg) {
    let image = document.querySelector(img);
    let input = document.getElementById(idInput);
    input.addEventListener("change", () => {
        newPictureForm.append(pictureImg);
        newPictureForm.append(createHtmlButtonSupp)
        image.src = URL.createObjectURL(input.files[0]);
    });
}

function createHtmlImg(pictureIndex, newPictureForm) {
    let pictureImg = document.createElement("img");
    pictureImg.src = "img.png";
    pictureImg.className = "rounded img-" + pictureIndex;
    return newPictureForm.append(pictureImg);
}

function addPictureButton(collection, newButton, pictureSpan) {

    let picturePrototype = collection.dataset.prototype;
    let pictureIndex = collection.dataset.index;

    picturePrototype = picturePrototype.replace(/__name__/g, pictureIndex);

    let pictureContent = document.createElement("html");
    pictureContent.innerHTML = picturePrototype;
    let newPictureForm = pictureContent.querySelector("div");
    let picImg = createHtmlImg(pictureIndex, newPictureForm);

    // newPictureForm.append(pictureImg);
    // newPictureForm.append(pictureButtonSupp);

    collection.dataset.index++;

    let pictureButtonAdd = collection.querySelector(".add-picture");

    pictureSpan.insertBefore(newPictureForm, pictureButtonAdd);


    loadImg("img.img-" + pictureIndex + "", "trick_pictures_" + pictureIndex + "_fileName", newPictureForm, picImg);
}

document.addEventListener('DOMContentLoaded', function () {
    // Code pour la section "image"
    let pictureCollection = document.querySelector('#picture');
    let pictureSpan = pictureCollection.querySelector("span");
    let pictureButtonAdd = document.createElement("button");

    console.log(pictureSpan);

    pictureButtonAdd.className = "btn btn-success add-picture my-3";
    pictureButtonAdd.type = "button";
    pictureButtonAdd.innerText = "Ajouter image";

    let newPictureButton = pictureSpan.append(pictureButtonAdd);

    pictureCollection.dataset.index = pictureCollection.querySelectorAll("input").length;

    pictureButtonAdd.addEventListener("click", function () {
        addPictureButton(pictureCollection, newPictureButton, pictureSpan);
    })


// Code pour la section "vidéo"
    let videoCollection = document.querySelector('#video');
    let videoSpan = videoCollection.querySelector("span");
    let videoButtonAdd = document.createElement("button");

    videoButtonAdd.className = "btn btn-success add-video my-3";
    videoButtonAdd.type = "button";
    videoButtonAdd.innerText = "Ajouter vidéo";

    let newVideoButton = videoSpan.append(videoButtonAdd);

    videoCollection.dataset.index = videoCollection.querySelectorAll("input").length;

    videoButtonAdd.addEventListener("click", function () {
        addVideoButton(videoCollection, newVideoButton);
    })

    function loadIframe(img, idInput) {
        let image = document.querySelector(img);
        let input = document.getElementById(idInput);
        input.addEventListener("change", () => {
            image.src = input.value;
        });
    }

    function addVideoButton(collection, newButton) {
        let videoPrototype = collection.dataset.prototype;
        let videoIndex = collection.dataset.index;

        videoPrototype = videoPrototype.replace(/__name__/g, videoIndex);

        let videoContent = document.createElement("html");
        videoContent.innerHTML = videoPrototype;
        let newVideoForm = videoContent.querySelector("div");
        // let src;

        let videoIframe = document.createElement("iframe");
        videoIframe.src = "";
        videoIframe.className = "rounded iframe-" + videoIndex;

        let videoButtonSupp = document.createElement("button");
        videoButtonSupp.type = "button";
        videoButtonSupp.className = "btn btn-danger d-flex";
        videoButtonSupp.id = "delete-video-" + videoIndex;
        videoButtonSupp.innerText = "Supprimer";

        newVideoForm.append(videoIframe);
        newVideoForm.append(videoButtonSupp);

        collection.dataset.index++;

        let videoButtonAdd = collection.querySelector(".add-video");

        videoSpan.insertBefore(newVideoForm, videoButtonAdd);

        videoButtonSupp.addEventListener("click", function () {
            this.previousElementSibling.parentElement.remove();
        });


        loadIframe("iframe.iframe-" + videoIndex + "", "trick_videos_" + videoIndex + "_url");
    }
});

