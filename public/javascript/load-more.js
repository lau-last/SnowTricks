document.addEventListener('DOMContentLoaded', function () {

    let button = document.getElementById("load-more");
    let container = document.getElementById("tricks-presentation");
    let limit = 3;

    document.getElementById("load-more").addEventListener("click", function (){

        button.disabled = true;

        let request = new XMLHttpRequest();
        let currentTrick = document.getElementsByClassName("trick-card-container").length;
        console.log(currentTrick);

        request.open("POST", "/load_trick", true);
        request.setRequestHeader("Content-type", "application/json");
        request.send(JSON.stringify({'offset': currentTrick, 'limit': limit}));

        request.onreadystatechange = function(){

            if (request.status === 200 && request.readyState === 4){

                container.innerHTML += request.responseText;
                button.disabled = false;

            }

        }

    });

}, false);