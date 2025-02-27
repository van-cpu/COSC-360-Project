let jobPostingCount = 0;
let applicantCount = 0;

// Validation Helpers (same as job seeker version)
function isValidText(text) {
    return text.trim().length > 0;
}

function isValidEmail(email) {
    const emailPattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*\.[a-zA-Z]{2,}$/;
    return emailPattern.test(email);
}

function isValidUrl(url) {
    const urlPattern = /^(https?:\/\/)?([a-zA-Z0-9-]+\.)*[a-zA-Z0-9-]+\.[a-zA-Z]{2,}(\/.*)?$/;
    return urlPattern.test(url) || url.trim() === '';
}

// Company Info Validation
function validateCompanyInfo() {
    const companyName = document.getElementById('company-name').value;
    const location = document.getElementById('location').value;
    const industry = document.getElementById('industry').value;
    const website = document.getElementById('website').value;

    let isValid = true;

    if (!isValidText(companyName)) {
        alert('Company Name is required and cannot be empty.');
        document.querySelector('#company-name').parentElement.classList.add('error');
        isValid = false;
    } else {
        document.querySelector('#company-name').parentElement.classList.remove('error');
    }

    if (!isValidText(location)) {
        alert('Location is required and cannot be empty.');
        document.querySelector('#location').parentElement.classList.add('error');
        isValid = false;
    } else {
        document.querySelector('#location').parentElement.classList.remove('error');
    }

    if (!isValidText(industry)) {
        alert('Industry is required and cannot be empty.');
        document.querySelector('#industry').parentElement.classList.add('error');
        isValid = false;
    } else {
        document.querySelector('#industry').parentElement.classList.remove('error');
    }

    if (website && !isValidUrl(website)) {
        alert('Please enter a valid website URL (e.g., https://www.company.com) or leave it blank.');
        document.querySelector('#website').parentElement.classList.add('error');
        isValid = false;
    } else {
        document.querySelector('#website').parentElement.classList.remove('error');
    }

    if (isValid) {
        alert('Company info updated successfully!');
        return true;
    }
    return false;
}

// Job Postings
function addJobPosting() {
    jobPostingCount++;
    const jobPostingsList = document.getElementById('job-postings-list');
    const jobPosting = document.createElement('div');
    jobPosting.className = 'job-posting';
    jobPosting.innerHTML = `
        <form id="job-posting-form-${jobPostingCount}" onsubmit="return saveJobPosting(${jobPostingCount})">
            <div class="form-group">
                <label for="job-title-${jobPostingCount}">Job Title</label>
                <input type="text" id="job-title-${jobPostingCount}" name="job-title" required>
            </div>
            <div class="form-group">
                <label for="job-description-${jobPostingCount}">Description</label>
                <textarea id="job-description-${jobPostingCount}" name="job-description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="job-location-${jobPostingCount}">Location</label>
                <input type="text" id="job-location-${jobPostingCount}" name="job-location" required>
            </div>
            <div class="form-group">
                <label for="job-requirements-${jobPostingCount}">Requirements</label>
                <textarea id="job-requirements-${jobPostingCount}" name="job-requirements" rows="4" required></textarea>
            </div>
            <button type="submit">Save Job</button>
            <button type="button" onclick="removeJobPosting(this, ${jobPostingCount})">Remove</button>
        </form>
    `;
    jobPostingsList.appendChild(jobPosting);
}

function saveJobPosting(postingId) {
    const jobTitle = document.getElementById(`job-title-${postingId}`).value;
    const jobDescription = document.getElementById(`job-description-${postingId}`).value;
    const jobLocation = document.getElementById(`job-location-${postingId}`).value;
    const jobRequirements = document.getElementById(`job-requirements-${postingId}`).value;

    let isValid = true;

    if (!isValidText(jobTitle)) {
        alert('Job Title is required and cannot be empty.');
        document.querySelector(`#job-title-${postingId}`).parentElement.classList.add('error');
        isValid = false;
    } else {
        document.querySelector(`#job-title-${postingId}`).parentElement.classList.remove('error');
    }

    if (!isValidText(jobDescription)) {
        alert('Description is required and cannot be empty.');
        document.querySelector(`#job-description-${postingId}`).parentElement.classList.add('error');
        isValid = false;
    } else {
        document.querySelector(`#job-description-${postingId}`).parentElement.classList.remove('error');
    }

    if (!isValidText(jobLocation)) {
        alert('Location is required and cannot be empty.');
        document.querySelector(`#job-location-${postingId}`).parentElement.classList.add('error');
        isValid = false;
    } else {
        document.querySelector(`#job-location-${postingId}`).parentElement.classList.remove('error');
    }

    if (!isValidText(jobRequirements)) {
        alert('Requirements are required and cannot be empty.');
        document.querySelector(`#job-requirements-${postingId}`).parentElement.classList.add('error');
        isValid = false;
    } else {
        document.querySelector(`#job-requirements-${postingId}`).parentElement.classList.remove('error');
    }

    if (isValid) {
        alert('Job posting saved successfully!');
        return true;
    }
    return false;
}

function removeJobPosting(button, postingId) {
    if (validateJobPosting(postingId)) {
        button.parentElement.parentElement.remove();
    }
}

function validateJobPosting(postingId) {
    const jobTitle = document.getElementById(`job-title-${postingId}`).value;
    const jobDescription = document.getElementById(`job-description-${postingId}`).value;
    const jobLocation = document.getElementById(`job-location-${postingId}`).value;
    const jobRequirements = document.getElementById(`job-requirements-${postingId}`).value;

    let isValid = true;
    if (!isValidText(jobTitle)) {
        alert('Job Title must have text and cannot be empty.');
        isValid = false;
    }
    if (!isValidText(jobDescription)) {
        alert('Description must have text and cannot be empty.');
        isValid = false;
    }
    if (!isValidText(jobLocation)) {
        alert('Location must have text and cannot be empty.');
        isValid = false;
    }
    if (!isValidText(jobRequirements)) {
        alert('Requirements must have text and cannot be empty.');
        isValid = false;
    }
    return isValid;
}

// Applicant Tracking Modal
function showApplicantDetails(button) {
    const applicantEntry = button.parentElement;
    const applicantText = applicantEntry.querySelector('p').textContent;
    const [nameEmail, jobTitle, status] = applicantText.split(' - ');

    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.id = 'applicant-modal';
    modal.innerHTML = `
        <div class="modal-content">
            <h3>Applicant Details</h3>
            <p><strong>Name and Email:</strong> ${nameEmail}</p>
            <p><strong>Applied for:</strong> ${jobTitle}</p>
            <p><strong>Status:</strong> ${status}</p>
            <div class="form-group">
                <label for="status-update">Update Status</label>
                <select id="status-update" name="status-update">
                    <option value="pending">Pending</option>
                    <option value="reviewed">Reviewed</option>
                    <option value="shortlisted">Shortlisted</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <button onclick="updateApplicantStatus('${nameEmail}', '${jobTitle}')">Update Status</button>
            <button onclick="closeModal('applicant-modal')">Close</button>
        </div>
    `;
    document.body.appendChild(modal);
    modal.style.display = 'flex';
}

function updateApplicantStatus(nameEmail, jobTitle) {
    const newStatus = document.getElementById('status-update').value;
    const applicantEntry = document.querySelector(`p:contains('${nameEmail} - ${jobTitle}')`).parentElement;
    applicantEntry.querySelector('p').textContent = `${nameEmail} - Applied for: ${jobTitle} - Status: ${newStatus}`;
    closeModal('applicant-modal');
    alert('Applicant status updated successfully!');
}

// Generic Functions
function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.remove();
}