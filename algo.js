

document.getElementById('iatype_demande').addEventListener('change', function () {
    var type = this.value;
    var options = document.querySelectorAll('#spe_demande option');
    options.forEach(function (option) {
        // Cache toutes les options
        option.hidden = true; 
        
        // Montre uniquement celles qui correspondent à la classe
        if (option.classList.contains(type)) {
            option.hidden = false;
        }
    });

    // Forcer le navigateur à redessiner le select (utile pour Safari)
    document.getElementById('spe_demande').style.display = 'none';
    document.getElementById('spe_demande').offsetHeight; // Déclencher un reflow
    document.getElementById('spe_demande').style.display = 'block';
});

// Initialisation des options en fonction de la valeur par défaut sélectionnée
document.getElementById('iatype_demande').dispatchEvent(new Event('change'));