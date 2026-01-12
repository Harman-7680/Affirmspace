document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const firstName = document.getElementById("first_name");
    const lastName = document.getElementById("last_name");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("password_confirmation");
    const gender = document.getElementById("gender");
    const role = document.getElementById("role");
    const terms = document.getElementById("accept-terms");
    const isAdult = document.getElementById("is_adult");
    const specialization = document.getElementById("specialization");
    const specializationContainer = document.getElementById(
        "specialization-container"
    );

    // Dynamic "Other gender" input
    const customGenderInput = document.createElement("input");
    customGenderInput.type = "text";
    customGenderInput.name = "custom_gender";
    customGenderInput.id = "custom_gender";
    customGenderInput.placeholder = "Please specify your gender";
    customGenderInput.className =
        "!w-full !rounded-lg !bg-transparent !shadow-sm !border-slate-200 dark:!border-slate-800 dark:!bg-white/5 mt-2.5 hidden";
    gender.parentNode.appendChild(customGenderInput);

    gender.addEventListener("change", function () {
        if (gender.value === "Other") {
            customGenderInput.classList.remove("hidden");
        } else {
            customGenderInput.classList.add("hidden");
            customGenderInput.value = "";
        }
    });

    // Helper functions
    function showError(input, message) {
        let errorEl = input.parentNode.querySelector(".error-message");
        if (!errorEl) {
            errorEl = document.createElement("div");
            errorEl.className = "error-message text-red-600 text-sm mt-1";
            input.parentNode.appendChild(errorEl);
        }
        errorEl.textContent = message;
    }

    function clearError(input) {
        let errorEl = input.parentNode.querySelector(".error-message");
        if (errorEl) errorEl.textContent = "";
    }

    form.addEventListener("submit", function (e) {
        let isValid = true;

        // First name
        const namePattern = /^[A-Za-z\s]+$/;
        if (!namePattern.test(firstName.value.trim())) {
            showError(
                firstName,
                "First name is required and must contain only letters."
            );
            isValid = false;
        } else clearError(firstName);

        // Last name
        if (!namePattern.test(lastName.value.trim())) {
            showError(
                lastName,
                "Last name is required and must contain only letters."
            );
            isValid = false;
        } else clearError(lastName);

        // Email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email.value.trim())) {
            showError(email, "Enter a valid email address.");
            isValid = false;
        } else clearError(email);

        // Password
        const passwordPattern =
            /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        if (!passwordPattern.test(password.value.trim())) {
            showError(
                password,
                "Password must be 8+ chars, include uppercase, lowercase, number, and special character."
            );
            isValid = false;
        } else clearError(password);

        // Confirm password
        if (password.value.trim() !== confirmPassword.value.trim()) {
            showError(confirmPassword, "Passwords do not match.");
            isValid = false;
        } else clearError(confirmPassword);

        // Role
        if (role.value === "") {
            showError(role, "Please select a user type.");
            isValid = false;
        } else clearError(role);

        // Specialization — only if counselor selected
        if (role.value === "1") {
            if (specialization.value.trim() === "") {
                showError(specialization, "Please select your specialization.");
                isValid = false;
            } else clearError(specialization);
        } else clearError(specialization);

        // Gender
        if (gender.value === "") {
            showError(gender, "Please select your gender.");
            isValid = false;
        } else {
            clearError(gender);
            if (
                gender.value === "Other" &&
                customGenderInput.value.trim() === ""
            ) {
                showError(customGenderInput, "Please specify your gender.");
                isValid = false;
            } else clearError(customGenderInput);
        }

        // Terms
        if (!terms.checked) {
            showError(terms, "You must accept the terms.");
            isValid = false;
        } else clearError(terms);

        // Age 18+
        if (!isAdult.checked) {
            showError(isAdult, "You must confirm you are 18+.");
            isValid = false;
        } else clearError(isAdult);

        if (!isValid) {
            e.preventDefault();
        }
    });
});
