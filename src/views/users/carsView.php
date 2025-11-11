<div>
    <h2>Mes véhicule</h2>
    <?php if (empty($cars)): ?>
    <p>Aucun véhicule renseigné.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($cars as $car): ?>
                <li>
                    <strong><?php echo $car['brand'] . ' ' . $car['model']; ?></strong><br>
                    <p>Couleur : <?php echo htmlspecialchars($car['color']) ?>. Energie : <?php echo htmlspecialchars($car['energy']); ?>
                    <p>Immatriculation : <?php echo htmlspecialchars($car['plate_number']); ?></p>
                    <p>Date de 1<sup>ère</sup> mise en circulation : <?php echo htmlspecialchars($car['first_registration']); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2>Ajouter un véhicule</h2>

    <form method="POST" action="">

        <input type="hidden" name="driver-id" value="<?php echo htmlspecialchars($user['id']); ?>">
        <label for="plate-number">Immatriculation : </label>
        <input type="text" id="plate-number" name="plate-number" placeholder="AA-000-BB" required>
        <label for="first-registration">Date de mise en circulation : </label>
        <input type="date" id="first-registration" name="first-registration" required>

        <br>
        <input type="text" id="brand" name="brand" placeholder="Marque" required>
        <input type="text" id="model" name="model" placeholder="Modèle" required>
        <input type="text" id="color" name="color" placeholder="Couleur" required>
        <select name="energy" id="energy" required>
            <option value="" selected disabled hidden>Type de moteur</option>
            <option value="essence">Essence</option>
            <option value="diesel">Diesel</option>
            <option value="hybride">Hybride</option>
            <option value="électrique">Électrique</option>
        </select>

        <button type="submit">Ajouter le véhicule</button>
    </form>

    <div>
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p style="color:red"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php elseif (!empty($success)): ?>
            <div class="success">
                <p style="color:green"><?= htmlspecialchars($success) ?></p>
            </div>
        <?php endif; ?>
    </div>

</div>
