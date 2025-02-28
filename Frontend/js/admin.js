document.addEventListener("DOMContentLoaded", function () {

    let checkboxes = document.querySelectorAll(".filterCheckbox");
    let issueList = document.getElementById("reportedIssues").children;
    let issueCount = document.getElementById("issueCount");
    let viewReportedIssue = document.getElementById("viewReportedIssue");
    let closeButton = document.getElementById("close");


    document.querySelectorAll(".viewProb").forEach((button) => {
        button.addEventListener("click", function () {

            viewReportedIssue.style.display = "block";
            //Later when making the menu appear, request job details from the server
        });
    });

    closeButton.addEventListener("click", function () {
        viewReportedIssue.style.display = "none";
    });

    issueCount.innerText = issueList.length;

    function filterIssues() {
        let activeFilters = [];


        for (let i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                activeFilters.push(checkboxes[i].value);
            }
        }


        for (let i = 0; i < issueList.length; i++) {
            let issueCategory = issueList[i].getAttribute("data-category");

            if (activeFilters.indexOf(issueCategory) !== -1) {
                issueList[i].style.display = "list-item";
            } else {
                issueList[i].style.display = "none";
            }
        }
    }


    for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener("change", filterIssues);
    }

    filterIssues();

});