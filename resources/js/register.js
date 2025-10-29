document.addEventListener('DOMContentLoaded', function() {
    const firstNameInput = document.getElementById('first_name');
    const lastNameInput = document.getElementById('last_name');
    const phoneInput = document.getElementById('phone');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const termsCheckbox = document.getElementById('terms');
    const submitBtn = document.getElementById('submitBtn');

    if (!firstNameInput || !lastNameInput) return; // Exit if fields don't exist

    // Function to capitalize first letter of each word
    function capitalizeWords(str) {
        return str.toLowerCase().replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }

    // Auto-capitalize first name when leaving field
    firstNameInput.addEventListener('blur', function() {
        this.value = capitalizeWords(this.value);
        checkFormValidity();
    });

    // Auto-capitalize last name when leaving field
    lastNameInput.addEventListener('blur', function() {
        this.value = capitalizeWords(this.value);
        checkFormValidity();
    });

    // Phone number validation - allow only numbers
    phoneInput.addEventListener('input', function(e) {
        // Remove any non-digit characters
        let value = e.target.value.replace(/\D/g, '');
        
        // Format with +51 prefix and spaces
        if (value.length > 0) {
            if (value.length <= 9) {
                value = '51' + value;
            }
            if (value.length >= 2) {
                value = '+' + value.substring(0, 2) + ' ' + value.substring(2);
            }
            if (value.length >= 7) {
                value = value.substring(0, 7) + ' ' + value.substring(7);
            }
            if (value.length >= 11) {
                value = value.substring(0, 11) + ' ' + value.substring(11, 15);
            }
        }
        
        e.target.value = value;
        checkFormValidity();
    });

    // Email validation
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Phone validation
    function isValidPhone(phone) {
        // Format should be: +51 XXX XXX XXX
        const phoneRegex = /^\+51\s\d{3}\s\d{3}\s\d{3}$/;
        return phoneRegex.test(phone);
    }

    // Check if all fields are valid
    function checkFormValidity() {
        const isFirstNameValid = firstNameInput.value.trim().length > 0;
        const isLastNameValid = lastNameInput.value.trim().length > 0;
        const isEmailValid = emailInput.value.trim().length > 0 && isValidEmail(emailInput.value);
        const isPhoneValid = phoneInput.value.trim().length > 0 && isValidPhone(phoneInput.value);
        const isPasswordValid = passwordInput.value.length >= 8;
        const isPasswordConfirmationValid = passwordConfirmationInput.value === passwordInput.value && passwordInput.value.length > 0;
        const isTermsAccepted = termsCheckbox.checked;

        if (isFirstNameValid && isLastNameValid && isEmailValid && isPhoneValid && 
            isPasswordValid && isPasswordConfirmationValid && isTermsAccepted) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    // Add event listeners
    emailInput.addEventListener('input', checkFormValidity);
    passwordInput.addEventListener('input', checkFormValidity);
    passwordConfirmationInput.addEventListener('input', checkFormValidity);
    termsCheckbox.addEventListener('change', checkFormValidity);

    // Initial check
    checkFormValidity();
});

