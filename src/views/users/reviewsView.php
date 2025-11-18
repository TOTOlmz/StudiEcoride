
<div class="center-container">
    <h2>Mes avis reçus</h2>

    <?php if ($average !== null): ?>
        <p><strong>Note moyenne :</strong> <?php echo $average; ?> / 5</p>
    <?php else: ?>
        <p>Aucune note reçue pour le moment.</p>
    <?php endif; ?>

    <?php if (count($reviewsReceived) > 0): ?>
        <div class="review-cards">
            <?php foreach ($reviewsReceived as $review): ?>
                <?php include __DIR__ . '/components/reviewCard.php'; ?>
            <?php endforeach; ?>
            </div>
    <?php else: ?>
        <p>Aucun commentaire reçu pour le moment.</p>
    <?php endif; ?>

    <h2>Mes avis laissés</h2>

    <?php if (count($reviewsLeft) > 0): ?>
        <div class="review-cards">
            <?php foreach ($reviewsLeft as $review): ?>
                <?php include __DIR__ . '/components/reviewCard.php'; ?>
            <?php endforeach; ?>
            </div>
    <?php else: ?>
        <p>Vous n'avez laissé aucune note.</p>
    <?php endif; ?>
    </div>