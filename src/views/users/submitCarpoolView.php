<div class="new-carpool-form">
    <h2>Proposer un nouveau trajet</h2>


    <form method="POST" action="">

        <label for="departure-city" class="form-label">Ville de départ</label>
        <input type="text" class="form-control" id="departure-city" name="departure-city" required>
        <label for="arrival-city" class="form-label">Ville d'arrivée</label>
        <input type="text" class="form-control" id="arrival-city" name="arrival-city" required>
        <br>
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" id="date" name="date" required>

        <label for="departure-time" class="form-label">Heure de départ</label>
        <input type="time" class="form-control" id="departure-time" name="departure-time" required>
        <label for="arrival-time" class="form-label">Heure d'arrivée</label>
        <input type="time" class="form-control" id="arrival-time" name="arrival-time" required>

        <br>
        <label for="price" class="form-label">Prix</label>
        <input type="number" class="form-control" id="price" name="price" step="0.5" required>
        <br>

        <label for="car-id" class="form-label">Choisir un véhicule</label>
        <select name="car-id" id="car-id" class="form-select" required>
            <option value="" selected disabled hidden>Choix du véhicule</option>
            <?php foreach ($cars as $c): ?>
                <option value="<?php echo $c['id']; ?>">
                    <?php echo $c['brand'] . ' ' . $c['model'] . ' (' . $c['energy'] . ')'; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="nb-seats" class="form-label">Nombre de places disponibles</label>
        <input type="number" class="form-control" id="nb-seats" name="nb-seats" min="1" value="1" required>
        <div>
        <p> Préférences de voyage </p>

            <label for="smoke" class="form-label">Fumeurs acceptés</label>
            <input type="checkbox" class="form-control" id="smoke" name="smoke">
            <br>
            <label for="animals" class="form-label">Animaux acceptés</label>
            <input type="checkbox" class="form-control" id="animals" name="animals">
            <br>
            <label for="preferences" class="form-label">Autres préférences</label>
            <input type="text" class="form-control" id="preferences" name="preferences">
        </div>


        <button type="submit">Créer le trajet</button>
    </form>

</div>


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
                            console.log(city);
                            const suggestion = document.createElement('div');
                            const cityName = city.properties.city || city.properties.name;      // city.coordinates[0] == lon et city.coordinates[1] == lat
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

    setupCityAutocomplete('departure-city');
    setupCityAutocomplete('arrival-city');

</script>