let isSignedIn = true;

function jobClicked(title){
    if(!isSignedIn){
        window.location.href = "login.html";
    }
    else{
        window.location.href = "job-details.html"
    }
}

function employerClicked(title){
    if(!isSignedIn){
        window.location.href = "login.html";
    }
    else{
        window.location.href = "profile-employer.html"
    }
}