document.addEventListener("DOMContentLoaded", function () {


    let book = document.getElementById("bookmark");
    let clicked = false;
    book.addEventListener("click", function () { 
        

        book.src = "/Frontend/photos/bookmarkClick.png"
        
        
        //book.style.transform = "scale(1)";

        
        if (clicked) {
            book.src = "/Frontend/photos/bookmark.png"; 
            book.style.transition = "transform 4.3s ease";
            book.style.transform = "scale(1)";
            clicked = false;
        } else {
            book.src = "/Frontend/photos/bookmarkClick.png";
            book.style.transition = "transform 0.3s ease";
            book.style.transform = "scale(1.8)";
            clicked = true;
        }
       
    });

});