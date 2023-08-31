function loadImg(img, idInput) {
    let image = document.querySelector(img);
    let input = document.getElementById(idInput);
    input.addEventListener("change", () => {
        image.src = URL.createObjectURL(input.files[0]);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // Code pour la section "image"
    let pictureCollection = document.querySelector('#picture');
    let pictureSpan = pictureCollection.querySelector("span");
    let pictureButtonAdd = document.createElement("button");

    pictureButtonAdd.className = "btn btn-success add-picture mb-3";
    pictureButtonAdd.type = "button";
    pictureButtonAdd.innerText = "Ajouter image";

    let newPictureButton = pictureSpan.append(pictureButtonAdd);

    pictureCollection.dataset.index = pictureCollection.querySelectorAll("input").length;

    pictureButtonAdd.addEventListener("click", function () {
        addPictureButton(pictureCollection, newPictureButton);
    })

    function addPictureButton(collection, newButton) {
        let picturePrototype = collection.dataset.prototype;
        let pictureIndex = collection.dataset.index;

        picturePrototype = picturePrototype.replace(/__name__/g, pictureIndex);

        let pictureContent = document.createElement("html");
        pictureContent.innerHTML = picturePrototype;
        let newPictureForm = pictureContent.querySelector("div");

        let pictureButtonSupp = document.createElement("button");
        pictureButtonSupp.type = "button";
        pictureButtonSupp.className = "btn btn-danger mb-3 d-flex";
        pictureButtonSupp.id = "delete-picture-" + pictureIndex;
        pictureButtonSupp.innerText = "Supprimer";

        let img = document.createElement("img");
        img.src = "";
        img.className = "rounded img-" + pictureIndex;

        newPictureForm.append(img);
        newPictureForm.append(pictureButtonSupp);

        collection.dataset.index++;

        let pictureButtonAdd = collection.querySelector(".add-picture");

        pictureSpan.insertBefore(newPictureForm, pictureButtonAdd);

        pictureButtonSupp.addEventListener("click", function () {
            this.previousElementSibling.parentElement.remove();
        });

        loadImg("img.img-" + pictureIndex + "", "trick_pictures_" + pictureIndex + "_fileName");
    }


    function loadIframe(img, idInput) {
        let image = document.querySelector(img);
        let input = document.getElementById(idInput);
        input.addEventListener("change", () => {
            image.src = input.value;
        });
    }

    // Code pour la section "vidéo"
    let videoCollection = document.querySelector('#video');
    let videoSpan = videoCollection.querySelector("span");
    let videoButtonAdd = document.createElement("button");
    videoButtonAdd.className = "btn btn-success add-video d-flex";
    videoButtonAdd.type = "button";
    videoButtonAdd.innerText = "Ajouter vidéo";

    let newVideoButton = videoSpan.append(videoButtonAdd);

    videoCollection.dataset.index = videoCollection.querySelectorAll("input").length;

    videoButtonAdd.addEventListener("click", function () {
        addVideoButton(videoCollection, newVideoButton);
    })

    function addVideoButton(collection, newButton) {
        let videoPrototype = collection.dataset.prototype;
        let videoIndex = collection.dataset.index;

        videoPrototype = videoPrototype.replace(/__name__/g, videoIndex);

        let videoContent = document.createElement("html");
        videoContent.innerHTML = videoPrototype;
        let newVideoForm = videoContent.querySelector("div");

        let videoButtonSupp = document.createElement("button");
        videoButtonSupp.type = "button";
        videoButtonSupp.className = "btn btn-danger mb-3";
        videoButtonSupp.id = "delete-video-" + videoIndex;
        videoButtonSupp.innerText = "Supprimer";

        let videoIframe = document.createElement("iframe");
        videoIframe.src = "";
        videoIframe.className = "rounded iframe-" + videoIndex;

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
 //   https://www.youtube.com/embed/0VMJ5vwus0I?si=7r8JOFUMhEvEVxMP

});