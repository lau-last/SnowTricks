document.addEventListener('DOMContentLoaded', function () {
    let pictureCollection, videoCollection, addPictureButton, addVideoButton;

    pictureCollection = document.querySelector("#picture");
    videoCollection = document.querySelector("#video");

    addPictureButton = createAddButton("Ajouter une image", addButton(pictureCollection));
    addVideoButton = createAddButton("Ajouter une vidéo", addButton(videoCollection));

    pictureCollection.dataset.index = pictureCollection.querySelectorAll("input").length;
    videoCollection.dataset.index = videoCollection.querySelectorAll("input").length;

    pictureCollection.querySelector("span").appendChild(addPictureButton);
    videoCollection.querySelector("span").appendChild(addVideoButton);
});

function createAddButton(text, clickHandler) {
    const button = document.createElement("button");
    button.type = "button";
    button.className = "add-item btn btn-success mb-3";
    button.innerText = text;
    button.addEventListener("click", clickHandler);
    return button;
}

function addButton(collection) {
    return function () {
        const prototype = collection.dataset.prototype;
        const index = collection.dataset.index;
        const newItem = createNewItem(prototype, index);
        const deleteButton = createDeleteButton(index);

        newItem.appendChild(deleteButton);

        collection.dataset.index++;
        collection.insertBefore(newItem, collection.querySelector("span"));

        deleteButton.addEventListener("click", function () {
            this.parentElement.remove();
        });
    };
}

function createNewItem(prototype, index) {
    const content = document.createElement("div");
    content.innerHTML = prototype;
    return content.querySelector("div");
}

function createDeleteButton(index) {
    const deleteButton = document.createElement("button");
    deleteButton.type = "button";
    deleteButton.className = "btn btn-danger mb-3";
    deleteButton.innerText = "Supprimer";
    deleteButton.id = "delete-item-" + index;
    return deleteButton;
}
