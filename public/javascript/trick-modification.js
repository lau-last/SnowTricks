document.addEventListener('DOMContentLoaded', function () {
    let buttonAddPicture = document.querySelector('#add-picture');
    let buttonAddVideo = document.querySelector('#add-video');
    let picture = document.getElementsByClassName("pic-to-change");

    let video = document.getElementsByClassName("video-to-change");

    buttonAddPicture.addEventListener("click", function () {
        buttonAddPicture.disabled = true;
        let index = document.querySelectorAll(".picture-fields").length;
        addFieldPicture();
        createFrame('#trick_pictures_', index, "img", "rounded img-");
        createButtonSupp('#trick_pictures_', index, "Supp picture", "#add-picture");
    });

    buttonAddVideo.addEventListener("click", function () {
        buttonAddVideo.disabled = true;
        let index = document.querySelectorAll(".video-fields").length;
        addFieldVideo();
        createFrame('#trick_videos_', index, "iframe", "rounded iframe-");
        createButtonSupp('#trick_videos_', index, "Supp video", "#add-video");
    });

    for (let i = 0; i < picture.length; i++) {
        editPicture('img#pic-to-change_' + (i + 1) + '', 'trick_pictures_' + i + '_file');
    }
    for (let j = 0; j < video.length; j++) {
        editIframe('iframe#video-to-change_' + (j + 1) + '', 'trick_videos_' + j + '_url');
    }
});