
<div class="car-card">
    <strong><?php echo $car['brand'] . ' ' . $car['model']; ?></strong><em> <?php echo htmlspecialchars($car['energy']); ?></em><br>
    <p>Couleur : <?php echo html_entity_decode($car['color'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></p>
    <p class="plate-number"><?php echo html_entity_decode($car['plate_number'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></p>
    <p>1<sup>ère</sup> mise en circulation : <?php echo htmlspecialchars($car['first_registration']); ?></p>
</div>