<div class="center-container">
    <h2>Proposer un nouveau trajet</h2>

    <?php include __DIR__ . '/../checks.php'; ?>
    
    <form class="new-carpool" method="POST" action="">

        <div>
            <input type="text"  class="carpool-form" id="departure-city" name="departure-city" placeholder="Ville de départ" required>
            <input type="text" class="carpool-form" id="arrival-city" name="arrival-city" placeholder="Ville d'arrivée" required>
        </div>

        <div>
            <label for="date" class="form-label">Date</label>
            <input type="date" class="carpool-form" id="date" name="date" required>
        </div>

        <div>
            <label for="departure-time" class="form-label">Heure de départ</label>
            <input type="time" class="carpool-form" id="departure-time" name="departure-time" required>
        </div>

        <div>
            <label for="arrival-time" class="form-label">Heure d'arrivée</label>
            <input type="time" class="carpool-form" id="arrival-time" name="arrival-time" required>
        </div>

        <div>
            <input type="number" class="carpool-form" id="nb-seats" name="nb-seats" min="1" placeholder="Nombre de places" required>
            <input type="number" class="carpool-form" id="price" name="price" step="0.5" placeholder="Prix par passager" required>
        </div>

        <select class="carpool-form" name="car-id" id="car-id" class="form-select" required>
            <option value="" selected disabled hidden>Choix du véhicule</option>
            <?php foreach ($cars as $c): ?>
                <option value="<?php echo $c['id']; ?>">
                    <?php echo $c['brand'] . ' ' . $c['model'] . ' (' . $c['energy'] . ')'; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div class="preferences">
            <p> Préférences de voyage </p>
                <div>
                <label for="smoke" class="form-label">Fumeurs acceptés 
                <input type="checkbox" id="smoke" name="smoke"></label>
                <label for="animals" class="form-label">Animaux acceptés 
                <input type="checkbox" id="animals" name="animals"></label>
            </div>
                <br>
                <label for="preferences" class="form-label">Autres préférences <br>
                <textarea class="carpool-form" id="preferences" name="preferences"></textarea></label>
        </div>


        <button class="button" type="submit">Créer le trajet</button>
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

    setupCityAutocomplete('departure-city');
    setupCityAutocomplete('arrival-city');

</script>