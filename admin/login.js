// Function to validate username
function validateUsername() {
    const usernameInput = document.getElementById("name");
    const usernameError = document.getElementById("usernameError");
    if (usernameInput.value.trim().length < 3) {
        usernameError.textContent = "Username must be at least 3 characters long.";
        return false;
    } else {
        usernameError.textContent = "";
        return true;
    }
}

// Function to validate email
function validateEmail() {
    const emailInput = document.getElementById("email");
    const emailError = document.getElementById("emailError");
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value.trim())) {
        emailError.textContent = "Enter a valid email address.";
        return false;
    } else {
        emailError.textContent = "";
        return true;
    }
}

// Function to validate password
function validatePassword() {
    const passwordInput = document.getElementById("password");
    const passwordError = document.getElementById("passwordError");
    if (passwordInput.value.trim().length < 6 || !/[A-Z]/.test(passwordInput.value) || !/[a-z]/.test(passwordInput.value) || !/\d/.test(passwordInput.value)) {
        passwordError.textContent = "Password must contain at least 1 lowercase, 1 uppercase, and 1 number, and be 6 characters long.";
        return false;
    } else {
        passwordError.textContent = "";
        return true;
    }
}

// Add event listeners for input events
document.getElementById("name").addEventListener("input", validateUsername);
document.getElementById("email").addEventListener("input", validateEmail);
document.getElementById("password").addEventListener("input", validatePassword);

// Add event listener for form submission
document.getElementById("registrationForm").addEventListener("submit", function(event) {
    // Prevent form submission if any of the validations fail
    if (!validateUsername() || !validateEmail() || !validatePassword()) {
        event.preventDefault();
    }
});

// Code to show/hide password and change icon
const pwShowHide = document.querySelectorAll(".showHidePw");
const pwFields = document.querySelectorAll("#password");

pwShowHide.forEach(eyeIcon => {
    eyeIcon.addEventListener("click", () => {
        pwFields.forEach(pwField => {
            if (pwField.type === "password") {
                pwField.type = "text";
                pwShowHide.forEach(icon => {
                    icon.classList.replace("uil-eye-slash", "uil-eye");
                });
            } else {
                pwField.type = "password";
                pwShowHide.forEach(icon => {
                    icon.classList.replace("uil-eye", "uil-eye-slash");
                });
            }
        });
    });
});

// Code to toggle between signup and login forms
const container = document.querySelector(".container");
const signUp = document.querySelector(".signup-link");
const login = document.querySelector(".login-link");

if (signUp) {
    signUp.addEventListener("click", () => {
        container.classList.add("active");
    });
}

if (login) {
    login.addEventListener("click", () => {
        container.classList.remove("active");
    });
}
