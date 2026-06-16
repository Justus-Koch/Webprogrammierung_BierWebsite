document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".review-form");
    if (!form) return;

    // Progressive Enhancement: Standard-Validierung aktivieren, falls JS läuft
    form.removeAttribute("novalidate");

    const emailInput = document.getElementById("username"); // ID in deinem HTML ist 'username'
    const passwordInput = document.getElementById("password");

    // Einfache Prüfung für das Passwort (darf beim Login bloß nicht leer sein)
    const validatePassword = () => {
        const isValid = passwordInput.value.trim() !== "";
        toggleError(passwordInput, isValid, "Bitte gib dein Passwort ein.");
        return isValid;
    };

    // Live-Validierung beim Tippen
    emailInput.addEventListener("input", () => validateEmailField(emailInput));
    passwordInput.addEventListener("input", validatePassword);

    // Validierung beim Absenden
    form.addEventListener("submit", (event) => {
        const isEmailValid = validateEmailField(emailInput);
        const isPasswordValid = validatePassword();

        if (!isEmailValid || !isPasswordValid) {
            event.preventDefault();
            // Fokus auf das erste fehlerhafte Feld setzen
            const firstError = form.querySelector(".js-error-message:not(:empty)");
            if (firstError) {
                firstError.parentNode.querySelector("input").focus();
            }
        }
    });
});