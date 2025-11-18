
<h1>Chercher un trajet</h1>
<?php include __DIR__ . '/components/carpoolResearch.php'; ?>

<h3>Affiner la recherche :</h3>
<?php include __DIR__ . '/components/carpoolFilters.php'; ?>

<?php if ($research): ?>
    <h2>Résultats de la recherche :</h2>
    <?php include __DIR__ . '/checks.php'; ?>
    <?php include __DIR__ . '/components/carpoolResults.php'; ?>
<?php endif; ?>

    