document.addEventListener("DOMContentLoaded", function () {

    let checkboxes = document.querySelectorAll(".filterCheckbox");
    let checkboxes1 = document.querySelectorAll(".filterCheckbox1");
    let issueList = document.getElementById("reportedIssues").children;
    let userList = document.getElementById("userList").children;
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


    
    function filterIssues1() {
        let activeFilters1 = [];


        for (let i = 0; i < checkboxes1.length; i++) {
            if (checkboxes1[i].checked) {
                activeFilters1.push(checkboxes1[i].value);
            }
        }


        for (let i = 0; i < userList.length; i++) {
            let issueCategory = userList[i].getAttribute("data-category");

            if (activeFilters1.indexOf(issueCategory) !== -1) {
                userList[i].style.display = "list-item";
            } else {
                userList[i].style.display = "none";
            }
        }
    }


    for (let i = 0; i < checkboxes.length; i++) {
        checkboxes1[i].addEventListener("change", filterIssues1);
    }


    filterIssues();
    filterIssues1();
});