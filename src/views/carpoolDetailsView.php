


<div class="center-container">
    <h1>Détails du covoiturage</h1>
    <?php include ROOT_PATH . 'src/views/checks.php'; ?>

    <div class="detail-cards">
        <div class="carpool-card">
            <h2>Trajet</h2>
            <?php include ROOT_PATH . 'src/views/components/detailsCarpool.php'; ?>
        </div>
        
        <div class="carpool-card">
            <h2>Conducteur</h2>
            <?php include ROOT_PATH . 'src/views/components/detailsDriver.php'; ?>
        </div>
        
        <div class="carpool-card">
            <h2>Véhicule</h2>
            <?php include ROOT_PATH . 'src/views/components/detailsCar.php'; ?>
        </div>
    </div>
</div>
<?php include ROOT_PATH . 'src/views/components/detailsBooking.php'; ?>