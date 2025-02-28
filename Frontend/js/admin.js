document.addEventListener("DOMContentLoaded", function () {

    let checkboxes = document.querySelectorAll(".filterCheckbox");
    let issueList = document.getElementById("reportedIssues").children;
    let issueCount = document.getElementById("issueCount");
    let viewReportedIssue = document.getElementById("viewReportedIssue");

    

    document.querySelectorAll(".viewProb").forEach((button) => {
        button.addEventListener("click", function () {

            viewReportedIssue.style.display = "block";
        });
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