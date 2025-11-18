
<div class="center-container">
    <?php include __DIR__ . '/../checks.php'; ?>
    <h2>Mes trajets à venir</h2>
    <?php if (!isset($activeCarpools) || count($activeCarpools) === 0): ?>
        <p>Vous n'avez pas de trajet planifié ou en cours.</p>
    <?php else: ?>
        <div class="history-carpools-cards">
            <?php foreach ($activeCarpools as $carpool): ?>
                <div class="carpool-card">
                    <?php include __DIR__ . '/components/carpoolsHistoryCard.php'; ?>
                    <?php include __DIR__ . '/components/historyActivesCActions.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <h2>Historique de mes trajets</h2>
    <?php if (!isset($historyCarpools) || count($historyCarpools) === 0): ?>
        <p>Vous n'avez aucun trajet terminé.</p>
    <?php else: ?>
        <div class="history-carpools-cards">
            <?php foreach ($historyCarpools as $carpool): ?>
                <div class="carpool-card">
                    <?php include __DIR__ . '/components/carpoolsHistoryCard.php'; ?>
                    <?php include __DIR__ . '/components/historyPassedCActions.php'; ?>
                </div>
            <?php endforeach; ?>
        </div>  
    <?php endif; ?>
</div>