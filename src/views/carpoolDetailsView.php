<style>
.detail-cards {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    max-width: 700px;
    margin: 2rem auto;
}

.detail-card {
    background: #fff;
    color: #196e44;
    border-radius: 12px;
    box-shadow: 0 2px 16px rgba(25, 110, 68, 0.08);
    padding: 1.5rem;
    list-style: none;
    margin: 0;
}
</style>

<div class="form-container" style="max-width: 900px;">
    <h1>Détails du covoiturage</h1>
    <?php include __DIR__ . '/checks.php'; ?>

    <div class="detail-cards">
            <h2>Trajet</h2>
            <?php include __DIR__ . '/components/detailsCarpool.php'; ?>
        
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