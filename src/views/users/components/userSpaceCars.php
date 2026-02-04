<h2>Mes véhicules <a href="./ajouter-un-vehicule">✚</a></h2>
<?php if (empty($cars)): ?>
    <p>Aucun véhicule renseigné.</p>
<?php else: ?>
    <div class="car-cards">
        <?php foreach ($cars as $car): ?>
            <?php include ROOT_PATH . 'src/Views/users/components/carsCard.php'; ?>
        <?php endforeach; ?>
        </div>
<?php endif; ?>
