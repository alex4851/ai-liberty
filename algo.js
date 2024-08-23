document.getElementById('iatype_demande').addEventListener('change', function () {
    var type = this.value;
    var speDemande = document.getElementById('spe_demande');
    var options = speDemande.querySelectorAll('option');

    options.forEach(function (option) {
        option.hidden = true; // Cache toutes les options
        if (option.classList.contains(type)) {
            option.hidden = false; // Affiche les options correspondant à la classe
        }
    });

    // Safari iOS: Redessiner le menu pour que les changements soient appliqués
    speDemande.style.display = 'inline-block';
    speDemande.offsetHeight; // Déclenche un reflow pour forcer la mise à jour
    speDemande.style.display = '';
});

// Initialisation des options en fonction de la valeur par défaut sélectionnée
document.getElementById('iatype_demande').dispatchEvent(new Event('change'));
