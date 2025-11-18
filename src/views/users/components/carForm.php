<div class="form-container">
    <form method="POST" action="">

        <input type="hidden" name="driver-id" value="<?php echo htmlspecialchars($user['id']); ?>">
        
        <div class="form-group">
            <label for="plate-number">Immatriculation :</label>
            <input type="text" id="plate-number" name="plate-number" placeholder="AA-000-BB" required>
        </div>
        
        <div class="form-group">
            <label for="first-registration">Date de mise en circulation :</label>
            <input type="date" id="first-registration" name="first-registration" required>
        </div>

        <div class="form-group">
            <input type="text" id="brand" name="brand" placeholder="Marque" required>
        </div>
        
        <div class="form-group">
            <input type="text" id="model" name="model" placeholder="Modèle" required>
        </div>
        
        <div class="form-group">
            <input type="text" id="color" name="color" placeholder="Couleur" required>
        </div>
        
        <div class="form-group">
            <select name="energy" id="energy" required>
                <option value="" selected disabled hidden>Type de moteur</option>
                <option value="essence">Essence</option>
                <option value="diesel">Diesel</option>
                <option value="hybride">Hybride</option>
                <option value="électrique">Électrique</option>
            </select>
        </div>

        <button name="adding-car-btn" type="submit">Ajouter le véhicule</button>
    </form>
</div>
