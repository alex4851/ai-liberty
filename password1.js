document.getElementById('togglePassword1').addEventListener('click', function (e) {
    // Récupérer l'élément input du mot de passe
    const passwordInput = document.getElementById('pass1');

    // Vérifier le type actuel de l'input
    const currentType = passwordInput.getAttribute('type');

    // Changer le type en fonction de l'état actuel
    if (currentType === 'password') {
        passwordInput.setAttribute('type', 'text');
        this.textContent = 'Masquer';
    } else {
        passwordInput.setAttribute('type', 'password');
        this.textContent = 'Afficher';
    }
});

