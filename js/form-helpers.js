// Funktion zum Anzeigen/Entfernen von Fehlermeldungen
function toggleError(inputElement, isValid, message) {
    let errorSpan = inputElement.parentNode.querySelector(".js-error-message");
    
    if (!errorSpan) {
        errorSpan = document.createElement("span");
        errorSpan.className = "js-error-message";
        errorSpan.style.color = "#d9534f";
        errorSpan.style.fontSize = "0.85rem";
        errorSpan.style.marginTop = "5px";
        errorSpan.style.display = "block";
        inputElement.parentNode.appendChild(errorSpan);
    }

    if (isValid) {
        errorSpan.textContent = "";
        inputElement.style.borderColor = "";
    } else {
        errorSpan.textContent = message;
        inputElement.style.borderColor = "#d9534f";
    }
}

// Zentrale E-Mail-Validierung
function validateEmailField(emailInput) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const isValid = emailRegex.test(emailInput.value.trim());
    toggleError(emailInput, isValid, "Bitte gib eine gültige E-Mail-Adresse ein.");
    return isValid;
}