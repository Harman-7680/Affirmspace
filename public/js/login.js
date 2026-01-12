function validateLoginForm() {
    let isValid = true;

    const email = document.getElementById("email");
    const password = document.getElementById("password");

    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    // Clear old errors
    emailError.textContent = "";
    passwordError.textContent = "";

    // Email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.value.trim() || !emailPattern.test(email.value.trim())) {
        emailError.textContent = "Please enter a valid email address.";
        isValid = false;
    }

    // Password validation
    // const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;
    // if (!password.value.trim() || !passwordPattern.test(password.value.trim())) {
    //     passwordError.textContent =
    //         "Password must be at least 6 characters long with at least 1 letter and 1 number.";
    //     isValid = false;
    // }

    if (!isValid) {
        return false; // stops form submission
    }

    return true;
}
