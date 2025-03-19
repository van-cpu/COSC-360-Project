// Toggle between login and signup forms
function showSignup() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('signup-form').style.display = 'block';
    updateEmployerFields();
}

function showLogin() {
    document.getElementById('signup-form').style.display = 'none';
    document.getElementById('login-form').style.display = 'block';
}

// Show/hide employer fields and manage required attributes
function updateEmployerFields() {
    const role = document.getElementById('signup-role').value;
    const employerFields = document.getElementById('employer-fields');
    const companyName = document.getElementById('signup-company-name');
    const location = document.getElementById('signup-location');
    const industry = document.getElementById('signup-industry');

    if (role === 'employer') {
        employerFields.style.display = 'block';
        companyName.setAttribute('required', 'true');
        location.setAttribute('required', 'true');
        industry.setAttribute('required', 'true');
    } else {
        employerFields.style.display = 'none';
        companyName.removeAttribute('required');
        location.removeAttribute('required');
        industry.removeAttribute('required');
    }
}

// Email validation function
function isValidEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

// Validate login form
function validateLoginForm() {
    const email = document.getElementById('login-email').value;
    if (!isValidEmail(email)) {
        alert('Please enter a valid email address (e.g., user@example.com).');
        return false;
    }
    return true;
}

// Validate signup form
function validateSignupForm() {
    const email = document.getElementById('signup-email').value;
    const password = document.getElementById('signup-password').value;
    const confirmPassword = document.getElementById('signup-confirm-password').value;

    if (!isValidEmail(email)) {
        alert('Please enter a valid email address (e.g., user@example.com).');
        return false;
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match. Please ensure both passwords are the same.');
        return false;
    }

    return true;
}

// Event listeners for role change and form visibility updates
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('signup-role').addEventListener('change', updateEmployerFields);
    updateEmployerFields();
});
