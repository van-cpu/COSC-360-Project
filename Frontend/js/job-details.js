document.addEventListener("DOMContentLoaded", function () {


    let book = document.getElementById("bookmark");
    let report = document.getElementById("report");
    let clicked = false;
    let clickedReport = false;
    book.addEventListener("click", function () {


        book.src = "/Frontend/photos/bookmarkClick.png"


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

    report.addEventListener("click", function () {


        report.src = "/Frontend/photos/bookmarkClick.png"


        if (clickedReport) {
            report.src = "/Frontend/photos/report.png";
            report.style.transition = "transform 4.3s ease";
            report.style.transform = "scale(1)";
            clickedReport = false;
        } else {
            report.src = "/Frontend/photos/reportClick.png";
            report.style.transition = "transform 0.3s ease";
            report.style.transform = "scale(1.8)";
            clickedReport = true;
        }

    });



});