<div class="search-box filters">
    <label>Écologique : <input type="checkbox" name="is-ecological"></label>
    <label>Prix max : <input type="number" name="price" min="0"></label>
    <label>Temps max : <input type="time" name="duration" value="00:00" step="300"></label>
    <label>Note min du chauffeur : <input type="number" name="rate" step="0.5" min="0" max="5"></label>
</div>


<script>

// Fonction permettant de filtrer les résultats
function filterCarpools() {
    const eco = document.querySelector('input[name="is-ecological"]').checked;
    const maxPrice = document.querySelector('input[name="price"]').value;
    const maxDuration = document.querySelector('input[name="duration"]').value;
    const minRate = document.querySelector('input[name="rate"]').value;

    document.querySelectorAll('.carpool-card').forEach(card => {

        let hidden = false;
        if (eco && card.dataset.eco !== "1") hidden = true;
        if (maxPrice && parseFloat(card.dataset.price) > parseFloat(maxPrice)) hidden = true;
        if (maxDuration && maxDuration !== "00:00") {
            const [h, m] = maxDuration.split(':');
            const maxDurMin = parseInt(h) * 60 + parseInt(m);
            if (parseInt(card.dataset.duration) > maxDurMin) hidden = true;
        }
        if (minRate && parseFloat(card.dataset.rate) < parseFloat(minRate)) hidden = true;
        card.style.display = hidden ? "none" : "";
    });
}
// Ajoute les listeners sur les filtres pour lancer la fonction à chaque changement d'état
document.querySelectorAll('.filters input').forEach(input => {
    input.addEventListener('input', filterCarpools);
    input.addEventListener('change', filterCarpools);
});

</script>