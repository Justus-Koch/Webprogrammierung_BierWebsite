document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".review-form");
    if (!form) return;

    form.removeAttribute("novalidate");

    const nickname = document.getElementById("nickname");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const passwordConfirm = document.getElementById("password_confirm");
    const checkbox_privacy = document.getElementById("checkbox_privacy");

    const validateNickname = () => {
        const isValid = nickname.value.trim() !== "";
        toggleError(nickname, isValid, "Bitte gib einen Nicknamen ein.");
        return isValid;
    };

    const validatePasswords = () => {
        let isMatchValid = password.value === passwordConfirm.value && passwordConfirm.value !== "";
        toggleError(passwordConfirm, isMatchValid, "Die Passwörter stimmen nicht überein.");

        return isMatchValid;
    };

    const validateCheckbox = () => {
        const isValid = checkbox_privacy.checked; 
        toggleError(checkbox_privacy, isValid, "Die Datenschutzerklärung und die Nutzungsbedingungen müssen akzeptiert werden.");
        return isValid
    }

    // Live-Validierung
    nickname.addEventListener("input", validateNickname);
    email.addEventListener("input", () => validateEmailField(email));
    password.addEventListener("input", validatePasswords);
    passwordConfirm.addEventListener("input", validatePasswords);
    checkbox_privacy.addEventListener("change", validateCheckbox);

    form.addEventListener("submit", (event) => {
        const isNicknameValid = validateNickname();
        const isEmailValid = validateEmailField(email);
        const isPasswordsValid = validatePasswords();
        const isCheckboxValid = validateCheckbox();

        if (!isNicknameValid || !isEmailValid || !isPasswordsValid || !isCheckboxValid) {
            event.preventDefault();
        }
    });
});