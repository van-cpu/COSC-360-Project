document.addEventListener("DOMContentLoaded", function(){


let book = document.getElementById("bookmark");

book.addEventListener("click",function(){

    book.classList.add("bookClick");
    book.src = "/Frontend/photos/defaultimage.png"

});

});
