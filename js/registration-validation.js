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

    const validatePasswords = () => {
        let isMatchValid = password.value === passwordConfirm.value && passwordConfirm.value !== "";
        toggleError(passwordConfirm, isMatchValid, "Die Passwörter stimmen nicht überein.");

        return isMatchValid;
    };

    // Live-Validierung
    nickname.addEventListener("input", validateNickname);
    email.addEventListener("input", () => validateEmailField(email));
    password.addEventListener("input", validatePasswords);
    passwordConfirm.addEventListener("input", validatePasswords);

    form.addEventListener("submit", (event) => {
        if (!validateNickname() || !validateEmailField(email) || !validatePasswords()) {
            event.preventDefault();
        }
    });
});