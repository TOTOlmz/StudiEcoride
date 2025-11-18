
<form class="search-box" method="POST" action="">
    <input type="text" class="form-control" id="departure-city" name="departure-city" placeholder="Départ" required>
    <input type="text" class="form-control" id="arrival-city" name="arrival-city" placeholder="Arrivée" required>
    <input type="date" class="form-control" name="date" min-value="<?php echo $currentDate; ?>" required>
    <input type="number" class="form-control" name="radius" placeholder="Rayon (km)">
    <button class="button" type="submit">Rechercher</button>
</form>

<script>

    // Script pour préremplir les champs départ et arrivée avec l'API data.gouv.fr
    function setupCityAutocomplete(inputName) {
        const input = document.querySelector(`input[name="${inputName}"]`);
        const suggestionBox = document.createElement('div');
        suggestionBox.style.position = 'absolute';
        suggestionBox.style.left = input.offsetLeft + 'px';
        suggestionBox.style.top = input.offsetTop + input.offsetHeight + 'px';
        suggestionBox.style.background = '#fff';
        suggestionBox.style.border = '1px solid #ccc';
        suggestionBox.style.zIndex = '1000';
        suggestionBox.style.width = input.offsetWidth + input.style.padding + 'px';
        suggestionBox.style.maxHeight = '200px';
        suggestionBox.style.overflowY = 'auto';
        suggestionBox.style.display = 'none';
        input.parentNode.appendChild(suggestionBox);

        input.addEventListener('input', function() {

            // On déclanche la recherche qu'a partir de 3 caractères
            const value = input.value;
            if (value.length < 3) {
                suggestionBox.style.display = 'none';
                return;
            }

            fetch(`https://api-adresse.data.gouv.fr/search/?q=${encodeURIComponent(value)}&type=municipality&limit=7`)
                .then(res => res.json())
                .then(data => {
                    suggestionBox.innerHTML = '';
                    if (data.features && data.features.length > 0) {
                        data.features.forEach(city => {
                            const suggestion = document.createElement('div');
                            const cityName = city.properties.city || city.properties.name;
                            const postalCode = city.properties.postcode || '';
                            suggestion.textContent = cityName + ' (' + postalCode + ')';        
                            suggestion.style.cursor = 'pointer';
                            suggestion.style.padding = '4px 8px';
                            suggestion.addEventListener('mousedown', function(e) {
                                input.value = cityName;
                                suggestionBox.style.display = 'none';
                            });
                            suggestionBox.appendChild(suggestion);
                        });
                        suggestionBox.style.display = 'block';
                    } else {
                        suggestionBox.style.display = 'none';
                    }
                });
        });

        // Masquer la box quand on quitte le champ
        input.addEventListener('blur', function() {
            setTimeout(() => suggestionBox.style.display = 'none', 150);
        });

        // Afficher la box si le champ a déjà du texte au focus
        input.addEventListener('focus', function() {
            if (input.value.length >= 3) {
                input.dispatchEvent(new Event('input'));
            }
        });

    }

    // Initialisation de la fonction avec des champs départ et arrivée
    setupCityAutocomplete('departure-city');
    setupCityAutocomplete('arrival-city');

</script>