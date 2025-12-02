<div class="hero">
    <h1>Trouvez le trajet qu'il vous faut avec EcoRide</h1>
    <form class="search-box" method="POST" action="./chercher-un-covoiturage">
        <input type="text" id="departure-city" name="departure-city" placeholder="Départ" required/>
        <input type="text" id="arrival-city" name="arrival-city" placeholder="Arrivée" required/>
        <input type="date" id="date" name="date" placeholder="Arrivée" required/>
        <button class="button" type="submit">Rechercher</button>
    </form>
</div>
<div class="society-presentation">
    <div class="card mobility">
        <h3>Une mobilité verte</h3>
        <p>Réduisez votre empreinte carbonne en privilégiant les trajets partagés en voiture électrique.</p>
    </div>
    <div class="card community">
        <h3>Une communautée engagée</h3>
        <p>Ne voyagez plus seul, trouvez le voyage qu'il vous faut ou partagez le votre.</p>
    </div>
    <div class="card economy">
        <h3>Une écconomie positive</h3>
        <p>Voyager avec EcoRide réduit le cout individuel du déplacement. Comme quoi, l'union fait la force.</p>
    </div>
</div>
<div class="offer">
    <h2>20 crédits offerts lors de votre inscription</h2>
    <p>
        Après tout cela, si vous ne savez toujours pas pourquoi vous inscrire sur EcoRide,
        <br>on ne peut plus rien pour vous ...
    </p>
    <a class="button" href="./inscription">Je m'inscris</a>
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
        suggestionBox.style.color = '#000';
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