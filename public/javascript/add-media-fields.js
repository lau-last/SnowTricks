document.addEventListener('DOMContentLoaded', function () {
    let count = 0;
    let pictureAddButton = createAddButton("Ajouter une image", "btn btn-success add-picture my-3");


    pictureAddButton.addEventListener('click', function () {
        let picturePrototype = getDatasetCollection('#picture').prototype;
        picturePrototype = picturePrototype.replace(/__name__/g, count);
        let pictureContent = document.createElement("html");
        pictureContent.innerHTML = picturePrototype;
        // let pictureIndex = getDatasetCollection('#picture').index;

        let newPictureForm = pictureContent.querySelector("div");
        console.log(picturePrototype);
        // insert(newPictureForm, "#pictures-span");
        document.querySelector("#pictures-span").append(newPictureForm);
        count++;
    });


    insert(pictureAddButton, "#pictures-span");


});


function createAddButton(text, classes) {
    console.log("createAddButton");
    let buttonAdd = document.createElement("button");
    buttonAdd.className = classes;
    buttonAdd.type = "button";
    buttonAdd.innerText = text;
    return buttonAdd;
}

function insert(element, selector) {
    console.log("insert");
    return document.querySelector(selector).append(element);
}

function getDatasetCollection(selector) {
    console.log("getDatasetCollection");
    return document.querySelector(selector).dataset;
}
