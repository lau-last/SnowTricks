document.addEventListener('DOMContentLoaded', function () {


    let button = document.getElementById("load-more-comment");
    let container = document.getElementById("container-comment");
    let limit = 5;
    let total = container.dataset.allComment;
    let trickId = container.dataset.trickId;
    let plusDeComment = document.getElementById("plus-de-comment");


    document.getElementById("load-more-comment").addEventListener("click", function () {

        button.disabled = true;

        let request = new XMLHttpRequest();
        let currentComment = document.getElementsByClassName("card-comment-container").length;


        if (currentComment + limit >= total) {
            button.hidden = true;
            plusDeComment.classList.remove("hidden");
        }

        request.open("POST", "/load-comment", true);
        request.setRequestHeader("Content-type", "application/json");
        request.send(JSON.stringify({'offset': currentComment, 'limit': limit, 'trickId': trickId}));

        request.onreadystatechange = function () {

            if (request.status === 200 && request.readyState === 4) {
                container.innerHTML += request.responseText;
                button.disabled = false;
                console.log(request.responseText);
            }

        }

    });

}, false);