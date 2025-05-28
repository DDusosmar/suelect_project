// Central password toggle function
function setupPasswordToggles() {
    const toggleButtons = document.querySelectorAll('.fas.fa-eye, .fas.fa-eye-slash');

    toggleButtons.forEach(function(toggleButton) {
        toggleButton.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling || document.getElementById(this.getAttribute('data-target'));
            
            if (passwordInput && (passwordInput.type === 'password' || passwordInput.type === 'text')) {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            }
        });
    });
}

// Password validation for signup
function setupPasswordValidation() {
    const password = document.getElementById('password');
    const lengthCheck = document.getElementById('length-check');
    const numberCheck = document.getElementById('number-check');
    const caseCheck = document.getElementById('case-check');
    
    // Only setup validation if we're on the signup page with these elements
    if (password && lengthCheck && numberCheck && caseCheck) {
        password.addEventListener('input', function() {
            const passwordValue = this.value;
            
            // Check length
            if (passwordValue.length >= 8) {
                lengthCheck.classList.add('valid');
                lengthCheck.textContent = '✔';
            } else {
                lengthCheck.classList.remove('valid');
                lengthCheck.textContent = '✖';
            }
            
            // Check number or symbol
            if (/[0-9]/.test(passwordValue) || /[!@#$%^&*(),.?":{}|<>]/.test(passwordValue)) {
                numberCheck.classList.add('valid');
                numberCheck.textContent = '✔';
            } else {
                numberCheck.classList.remove('valid');
                numberCheck.textContent = '✖';
            }
            
            // Check lowercase and uppercase
            if (/[a-z]/.test(passwordValue) && /[A-Z]/.test(passwordValue)) {
                caseCheck.classList.add('valid');
                caseCheck.textContent = '✔';
            } else {
                caseCheck.classList.remove('valid');
                caseCheck.textContent = '✖';
            }
        });
    }
}

// Signup multi-step form
function setupSignupSteps() {
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    
    if (step1 && step2 && nextBtn && prevBtn) {
        nextBtn.addEventListener('click', function() {
            step1.classList.add('hidden');
            step2.classList.remove('hidden');
        });

        prevBtn.addEventListener('click', function() {
            step2.classList.add('hidden');
            step1.classList.remove('hidden');
        });
    }
}

// Popup functionality
function setupPopup() {
    const popup = document.getElementById('accountPopup');
    const closeBtn = document.getElementById('closePopup');
    const yesBtn = document.getElementById('yesButton');
    const noBtn = document.getElementById('noButton');
    
    if (popup && closeBtn && yesBtn && noBtn) {
        let popupClosed = false;
        
        setTimeout(function() {
            showPopup();
        }, 5000);
        
        closeBtn.addEventListener('click', function() {
            hidePopup();
            popupClosed = true;
            
            setTimeout(function() {
                if (popupClosed) {
                    showPopup();
                    popupClosed = false;
                }
            }, 60000);
        });
        
        yesBtn.addEventListener('click', function() {
            window.location.href = 'login.php';
        });
        
        noBtn.addEventListener('click', function() {
            window.location.href = 'signup.php';
        });
        
        function showPopup() {
            popup.classList.add('show');
        }
        
        function hidePopup() {
            popup.classList.remove('show');
        }
    }
}

// Initialize all functionality when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    setupPasswordToggles();
    setupPasswordValidation();
    setupSignupSteps();
    setupPopup();
});