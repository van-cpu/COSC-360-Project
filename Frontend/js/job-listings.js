let isSignedIn = false;

function jobClicked(title){
    if(!isSignedIn){
        window.location.href = "login.html";
    }
    else{
        window.location.href = "job-details.html"
    }
}

function tagSelect(name) {
    let button = document.getElementById(name);
    if (button) {
        button.classList.toggle("selected");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    let searchInput = document.querySelector(".search input");
    let jobCardsContainer = document.querySelector(".card");
    let jobCards = Array.from(document.querySelectorAll(".jobcard"));

    searchInput.addEventListener("input", function () {
        let search = searchInput.value.toLowerCase().trim();
        
        // Sort job cards based on similarity to the search input
        jobCards.sort((a, b) => {
            let titleA = a.querySelector("h2").innerText.toLowerCase();
            let titleB = b.querySelector("h2").innerText.toLowerCase();
            return getSimilarity(search, titleB) - getSimilarity(search, titleA);
        });

        // Reorder job cards in the DOM
        jobCards.forEach(card => jobCardsContainer.appendChild(card));
    });
});

// Function to calculate similarity score between input and job title
function getSimilarity(input, title) {
    if (!input) return 0;
    if (title.includes(input)) return 2; 
    
    let words = title.split(" ");
    let score = 0;
    words.forEach(word => {
        if (word.startsWith(input)) score += 1; 
    });
    
    return score;
}
