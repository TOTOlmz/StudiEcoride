<div class="staff-panel">
    <?php include __DIR__ . '/../checks.php'; ?>
    <?php include __DIR__ . '/components/logout.php'; ?>
</div>
<div class="staff-panel">
    <h2>Avis en attente (<?php echo count($pendingReviews) ?>)</h2>
    <div class="review-cards">
        <?php if (empty($pendingReviews)): ?>
            <p>Aucun avis en attente.</p>
        <?php else: ?>
            
            <?php foreach ($pendingReviews as $review): ?>
                <?php include __DIR__ . '/components/reviews.php'; ?>
            <?php endforeach; ?>
            
        <?php endif; ?>
    </div>
</div>

<div class="staff-panel">
    <h2>Signalements en cours (<?php echo count($currentReports) ?>)</h2>
    <div class="reports-section">
        <?php if (empty($currentReports)): ?>
            <p>Aucun signalement en cours.</p>
        <?php else: ?>
            <div class="review-cards">
                <?php foreach ($currentReports as $report): ?>
                    <div class="review-card">
                        <?php include __DIR__ . '/components/reports.php'; ?>
                        <div class="actions">
                            <form method="POST">
                                <input type="hidden" name="report-id" value="<?php echo $report['id'] ?>">
                                <button class="button" name="close-report">Cloturer</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <h2>Signalements en attente (<?php echo count($pendingReports) ?>)</h2>
    <div class="reports-section">
        <?php if (empty($pendingReports)): ?>
            <p>Aucun signalement en attente.</p>
        <?php else: ?>
            <div class="review-cards">
                <?php foreach ($pendingReports as $report): ?>
                    <div class="review-card">
                        <?php include __DIR__ . '/components/reports.php'; ?>
                        <div class="actions">
                            <form method="POST">
                                <input type="hidden" name="report-id" value="<?php echo $report['id'] ?>">
                                <button class="button" name="open-report">Traiter</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
