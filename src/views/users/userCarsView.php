<div class="center-container">

    <?php include __DIR__ . '/../checks.php'; ?>

    <h2>Mes véhicule</h2>
    <?php if (empty($cars)): ?>
    <p>Aucun véhicule renseigné.</p>
    <?php else: ?>
        <div class="car-cards">
            <?php foreach ($cars as $car): ?>
                <?php include __DIR__ . '/components/carsCard.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <h2>Ajouter un véhicule</h2>

    <?php include __DIR__ . '/components/carForm.php'; ?>




</div