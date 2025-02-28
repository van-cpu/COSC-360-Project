let jobPreferenceCount = 0;
let experienceCount = 0;
let skillsCount = 0;
let educationCount = 0;

// Validation Helpers
function isValidName(name) {
    return name.trim().length > 0;
}

function isValidEmail(email) {
    const emailPattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*\.[a-zA-Z]{2,}$/;
    return emailPattern.test(email);
}

function isValidPhone(phone) {
    const phonePattern = /^\d{10}$|^\d{3}-\d{3}-\d{4}$/; // Accepts 10 digits or XXX-XXX-XXXX
    return phonePattern.test(phone.replace(/\D/g, '')); // Remove non-digits for validation
}

function isValidText(text) {
    return text.trim().length > 0;
}

function isValidDate(date) {
    return date && !isNaN(new Date(date).getTime());
}

// Job Preferences
function addJobPreference() {
    jobPreferenceCount++;
    const jobPreferencesList = document.getElementById('job-preferences-list');
    const entry = document.createElement('div');
    entry.className = 'entry';
    entry.innerHTML = `
        <input type="text" placeholder="Job Preference ${jobPreferenceCount}" name="job-preference-${jobPreferenceCount}">
        <button onclick="removeEntry(this, 'job-preference')">Remove</button>
    `;
    jobPreferencesList.appendChild(entry);
}

// Skills
function addSkill() {
    skillsCount++;
    const skillsList = document.getElementById('skills-list');
    const entry = document.createElement('div');
    entry.className = 'entry';
    entry.innerHTML = `
        <input type="text" placeholder="Skill ${skillsCount}" name="skill-${skillsCount}">
        <button onclick="removeEntry(this, 'skill')">Remove</button>
    `;
    skillsList.appendChild(entry);
}

// Experience Modal
function showExperienceForm() {
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.id = 'experience-modal';
    modal.innerHTML = `
        <div class="modal-content">
            <h3>Add Experience</h3>
            <form id="experience-form" onsubmit="return saveExperience()">
                <div class="form-group">
                    <label for="job-title">Job Title</label>
                    <input type="text" id="job-title" name="job-title" required>
                </div>
                <div class="form-group">
                    <label for="company-name">Company Name</label>
                    <input type="text" id="company-name" name="company-name" required>
                </div>
                <div class="form-group">
                    <label for="start-date">Start Date</label>
                    <input type="date" id="start-date" name="start-date" required>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="current-job" name="current-job" onchange="toggleEndDate()"> Current Job
                    </label>
                </div>
                <div class="form-group" id="end-date-group">
                    <label for="end-date">End Date</label>
                    <input type="date" id="end-date" name="end-date">
                </div>
                <div class="form-group">
                    <label for="responsibilities">Responsibilities</label>
                    <textarea id="responsibilities" name="responsibilities" rows="4" required></textarea>
                </div>
                <button type="submit">Save</button>
                <button type="button" onclick="closeModal('experience-modal')">Cancel</button>
            </form>
        </div>
    `;
    document.body.appendChild(modal);
    modal.style.display = 'flex';
}

function toggleEndDate() {
    const isCurrent = document.getElementById('current-job').checked;
    const endDateGroup = document.getElementById('end-date-group');
    endDateGroup.style.display = isCurrent ? 'none' : 'block';
}

function saveExperience() {
    const jobTitle = document.getElementById('job-title').value;
    const companyName = document.getElementById('company-name').value;
    const startDate = document.getElementById('start-date').value;
    const isCurrent = document.getElementById('current-job').checked;
    const endDate = document.getElementById('end-date') ? document.getElementById('end-date').value : '';
    const responsibilities = document.getElementById('responsibilities').value;

    // Validation
    let isValid = true;
    if (!isValidText(jobTitle)) {
        alert('Job Title is required and cannot be empty.');
        isValid = false;
    }
    if (!isValidText(companyName)) {
        alert('Company Name is required and cannot be empty.');
        isValid = false;
    }
    if (!isValidDate(startDate)) {
        alert('Start Date is required and must be a valid date.');
        isValid = false;
    }
    if (!isCurrent && !isValidDate(endDate)) {
        alert('End Date is required (if not current job) and must be a valid date.');
        isValid = false;
    }
    if (!isValidText(responsibilities)) {
        alert('Responsibilities are required and cannot be empty.');
        isValid = false;
    }
    if (isCurrent && endDate) {
        alert('End Date should not be provided for current jobs.');
        isValid = false;
    }
    if (!isCurrent && endDate && new Date(endDate) < new Date(startDate)) {
        alert('End Date cannot be earlier than Start Date.');
        isValid = false;
    }

    if (!isValid) return false;

    experienceCount++;
    const experienceList = document.getElementById('experience-list');
    const entry = document.createElement('div');
    entry.className = 'entry';
    entry.innerHTML = `
        <p>${jobTitle} at ${companyName} (${startDate} - ${isCurrent ? 'Present' : endDate})</p>
        <p>Responsibilities: ${responsibilities}</p>
        <button onclick="removeEntry(this, 'experience')">Remove</button>
    `;
    experienceList.appendChild(entry);
    closeModal('experience-modal');
    return false; // Prevent default form submission
}

// Education Modal
function showEducationForm() {
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.id = 'education-modal';
    modal.innerHTML = `
        <div class="modal-content">
            <h3>Add Education</h3>
            <form id="education-form" onsubmit="return saveEducation()">
                <div class="form-group">
                    <label for="education-level">Education Level</label>
                    <select id="education-level" name="education-level" required>
                        <option value="high-school">High School Diploma</option>
                        <option value="associate">Associate Degree</option>
                        <option value="bachelor">Bachelor's Degree</option>
                        <option value="master">Master's Degree</option>
                        <option value="doctorate">Doctorate (PhD)</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="institution-name">Institution Name</label>
                    <input type="text" id="institution-name" name="institution-name" required>
                </div>
                <div class="form-group">
                    <label for="graduation-date">Graduation Date or Expected</label>
                    <input type="date" id="graduation-date" name="graduation-date" required>
                </div>
                <button type="submit">Save</button>
                <button type="button" onclick="closeModal('education-modal')">Cancel</button>
            </form>
        </div>
    `;
    document.body.appendChild(modal);
    modal.style.display = 'flex';
}

function saveEducation() {
    const educationLevel = document.getElementById('education-level').value;
    const institutionName = document.getElementById('institution-name').value;
    const graduationDate = document.getElementById('graduation-date').value;

    // Validation
    let isValid = true;
    if (!isValidText(educationLevel)) {
        alert('Education Level is required and cannot be empty.');
        isValid = false;
    }
    if (!isValidText(institutionName)) {
        alert('Institution Name is required and cannot be empty.');
        isValid = false;
    }
    if (!isValidDate(graduationDate)) {
        alert('Graduation Date is required and must be a valid date.');
        isValid = false;
    }

    if (!isValid) return false;

    educationCount++;
    const educationList = document.getElementById('education-list');
    const entry = document.createElement('div');
    entry.className = 'entry';
    entry.innerHTML = `
        <p>${educationLevel} from ${institutionName} (${graduationDate})</p>
        <button onclick="removeEntry(this, 'education')">Remove</button>
    `;
    educationList.appendChild(entry);
    closeModal('education-modal');
    return false; // Prevent default form submission
}

// Job Preferences and Skills Validation (on remove or before saving, if needed)
function validateEntries(listId, type) {
    const entries = document.querySelectorAll(`#${listId} .entry input`);
    let isValid = true;
    entries.forEach(entry => {
        if (!isValidText(entry.value)) {
            alert(`All ${type} must have text and cannot be empty.`);
            isValid = false;
        }
    });
    return isValid;
}

// Personal Info Validation
function validatePersonalInfo() {
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;

    let isValid = true;

    if (!isValidName(name)) {
        alert('Name is required and cannot be empty.');
        document.querySelector('#name').parentElement.classList.add('error');
        isValid = false;
    } else {
        document.querySelector('#name').parentElement.classList.remove('error');
    }

    if (!isValidEmail(email)) {
        alert('Please enter a valid email address (e.g., user.name123@example.co.uk).');
        document.querySelector('#email').parentElement.classList.add('error');
        isValid = false;
    } else {
        document.querySelector('#email').parentElement.classList.remove('error');
    }

    if (!isValidPhone(phone)) {
        alert('Please enter a valid phone number (e.g., 1234567890 or 123-456-7890).');
        document.querySelector('#phone').parentElement.classList.add('error');
        isValid = false;
    } else {
        document.querySelector('#phone').parentElement.classList.remove('error');
    }

    if (isValid) {
        alert('Profile updated successfully!');
        return true;
    }
    return false;
}

// Generic Functions
function removeEntry(button, type) {
    const listId = {
        'job-preference': 'job-preferences-list',
        'skill': 'skills-list',
        'experience': 'experience-list',
        'education': 'education-list'
    }[type];
    
    if (validateEntries(listId, type.replace('-', ' ').toUpperCase())) {
        button.parentElement.remove();
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) modal.remove();
}