// Toggle between login and signup forms
function showSignup() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('signup-form').style.display = 'block';
    updateEmployerFields(); // Check role on form display
}

function showLogin() {
    document.getElementById('signup-form').style.display = 'none';
    document.getElementById('login-form').style.display = 'block';
}

// Function to show/hide employer fields based on role
function updateEmployerFields() {
    const role = document.getElementById('signup-role').value;
    const employerFields = document.getElementById('employer-fields');
    if (role === 'employer') {
        employerFields.style.display = 'block';
    } else {
        employerFields.style.display = 'none';
    }
}

// Email validation function
function isValidEmail(email) {
    // Basic regex for email validation: requires @ and a domain
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

// Validate login form
function validateLoginForm() {
    const email = document.getElementById('login-email').value;
    if (!isValidEmail(email)) {
        alert('Please enter a valid email address (e.g., user@example.com).');
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}

// Validate signup form
function validateSignupForm() {
    const email = document.getElementById('signup-email').value;
    const password = document.getElementById('signup-password').value;
    const confirmPassword = document.getElementById('signup-confirm-password').value;

    // Check email format
    if (!isValidEmail(email)) {
        alert('Please enter a valid email address (e.g., user@example.com).');
        return false; // Prevent form submission
    }

    // Check if passwords match
    if (password !== confirmPassword) {
        alert('Passwords do not match. Please ensure both passwords are the same.');
        return false; // Prevent form submission
    }

    return true; // Allow form submission
}

// Add event listener to update fields when role changes
document.getElementById('signup-role').addEventListener('change', updateEmployerFields);

// Initialize employer fields visibility on page load
updateEmployerFields();