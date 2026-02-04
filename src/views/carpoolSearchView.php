<div class="center-container">
    <h1>Chercher un trajet</h1>
    <?php include ROOT_PATH . 'src/Views/components/carpoolResearch.php'; ?>

    <h3>Affiner la recherche :</h3>
    <?php include ROOT_PATH . 'src/Views/components/carpoolFilters.php'; ?>

    <?php if ($research): ?>
        <h2>Résultats de la recherche :</h2>
        <?php include ROOT_PATH . 'src/Views/checks.php'; ?>
        <?php include ROOT_PATH . 'src/Views/components/carpoolResults.php'; ?>
    <?php endif; ?>
</div>
    