let currentPage = 1;

function searchJobs(page = 1) {
    const keyword = document.getElementById('searchInput').value;
    currentPage = page;

    fetch(`../PHP/search-jobs.php?keyword=${encodeURIComponent(keyword)}&page=${page}`)
        .then(response => response.json())
        .then(data => {
            const jobContainer = document.getElementById('jobResults');
            jobContainer.innerHTML = '';

            if (data.jobs.length === 0) {
                jobContainer.innerHTML = '<p>No jobs found.</p>';
                return;
            }

            data.jobs.forEach(job => {
                const jobCard = document.createElement('div');
                jobCard.className = 'jobcard';
                jobCard.onclick = () => jobClicked(job.id);
                jobCard.innerHTML = `
                    <h2>${job.title}</h2>
                    <p>${job.job_description}</p>
                    <p><strong>Company:</strong> ${job.company}</p>
                    <p><strong>Location:</strong> ${job.location || 'N/A'}</p>
                `;
                jobContainer.appendChild(jobCard);
            });
            window.scrollTo({ top: 0, behavior: 'smooth' });

            renderPagination(data.totalPages, data.currentPage);
        })
        .catch(error => {
            console.error('Error fetching jobs:', error);
        });


}

function renderPagination(totalPages, currentPage) {
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = '';

    const maxVisible = 5; // Total buttons (excluding first/last)
    const pageButtons = [];

    // Helper to create a page button
    const createPageButton = (page, label = null) => {
        const btn = document.createElement('button');
        btn.innerText = label || page;
        if (page === currentPage) btn.classList.add('active');
        btn.onclick = () => searchJobs(page);
        paginationContainer.appendChild(btn);
    };

    // Always show the first page
    createPageButton(1);

    // Left ellipsis
    if (currentPage > 3) {
        const ellipsis = document.createElement('span');
        ellipsis.innerText = '...';
        ellipsis.style.margin = '0 5px';
        ellipsis.style.color = '#ccc';
        paginationContainer.appendChild(ellipsis);
    }

    // Middle page buttons
    let start = Math.max(2, currentPage - 1);
    let end = Math.min(totalPages - 1, currentPage + 1);

    if (currentPage === 1) {
        end = Math.min(totalPages - 1, currentPage + 2);
    } else if (currentPage === totalPages) {
        start = Math.max(2, currentPage - 2);
    }

    for (let i = start; i <= end; i++) {
        createPageButton(i);
    }

    // Right ellipsis
    if (currentPage < totalPages - 2) {
        const ellipsis = document.createElement('span');
        ellipsis.innerText = '...';
        ellipsis.style.margin = '0 5px';
        ellipsis.style.color = '#ccc';
        paginationContainer.appendChild(ellipsis);
    }

    // Last page
    if (totalPages > 1) {
        createPageButton(totalPages);
    }
}


document.addEventListener("DOMContentLoaded", function () {
    searchJobs();
    document.getElementById('searchInput').addEventListener('input', () => searchJobs(1));
});
