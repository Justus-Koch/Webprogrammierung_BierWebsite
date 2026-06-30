document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".review-form");
    if (!form) return;

    form.removeAttribute("novalidate");

    const nickname = document.getElementById("nickname");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const passwordConfirm = document.getElementById("password_confirm");

    const validateNickname = () => {
        const isValid = nickname.value.trim() !== "";
        toggleError(nickname, isValid, "Bitte gib einen Nicknamen ein.");
        return isValid;
    };

    // Passwort-Sicherheitsprüfung
    const validatePasswordSecurity = () => {
        const value = password.value;

        const hasMinLength = value.length >= 8;
        const hasUppercase = /[A-Z]/.test(value);
        const hasSpecialChar = /[\W_]/.test(value);

        let errorMessage = "";

        if (!hasMinLength) {
            errorMessage = "Das Passwort muss mindestens 8 Zeichen lang sein.";
        } else if (!hasUppercase) {
            errorMessage = "Das Passwort muss mindestens einen Großbuchstaben enthalten.";
        } else if (!hasSpecialChar) {
            errorMessage = "Das Passwort muss mindestens ein Sonderzeichen enthalten.";
        }

        const isValid = hasMinLength && hasUppercase && hasSpecialChar;

        toggleError(password, isValid, errorMessage);

        return isValid;
    };

    const validatePasswords = () => {
        const isMatchValid =
            password.value === passwordConfirm.value &&
            passwordConfirm.value !== "";

        toggleError(
            passwordConfirm,
            isMatchValid,
            "Die Passwörter stimmen nicht überein."
        );

        return isMatchValid;
    };

    // Live-Validierung
    nickname.addEventListener("input", validateNickname);
    email.addEventListener("input", () => validateEmailField(email));

    password.addEventListener("input", () => {
        validatePasswordSecurity();
        validatePasswords();
    });

    passwordConfirm.addEventListener("input", validatePasswords);

    form.addEventListener("submit", (event) => {
        const isNicknameValid = validateNickname();
        const isEmailValid = validateEmailField(email);
        const isPasswordSecure = validatePasswordSecurity();
        const isPasswordsValid = validatePasswords();

        if (
            !isNicknameValid ||
            !isEmailValid ||
            !isPasswordSecure ||
            !isPasswordsValid
        ) {
            event.preventDefault();
        }
    });
});
