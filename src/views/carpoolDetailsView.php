
<div class="center-container">
    <h1>Détails du covoiturage</h1>
    <?php include __DIR__ . '/checks.php'; ?>

    <div class="detail-cards">
        <div class="carpool-card">
            <h2>Trajet</h2>
            <?php include __DIR__ . '/components/detailsCarpool.php'; ?>
        </div>
        
        <div class="carpool-card">
            <h2>Conducteur</h2>
            <?php include __DIR__ . '/components/detailsDriver.php'; ?>
        </div>
        
        <div class="carpool-card">
            <h2>Véhicule</h2>
            <?php include __DIR__ . '/components/detailsCar.php'; ?>
        </div>
    </div>
    <?php include __DIR__ . '/components/detailsBooking.php'; ?>
</div>