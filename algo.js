document.getElementById('iatype_demande').addEventListener('change', function () {
    var type = this.value;
    var options = document.querySelectorAll('#spe_demande option');
    options.forEach(function (option) {
        option.style.display = 'none';
        if (option.classList.contains(type)) {
            option.style.display = 'block';
        }
    });
});

// Initialize the options based on the default selected type
document.getElementById('iatype_demande').dispatchEvent(new Event('change'));