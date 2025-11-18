<ul class="detail-card">
    <li><strong>Marque :</strong> <?php echo html_entity_decode($car['brand'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></li>
    <li><strong>Modèle :</strong> <?php echo html_entity_decode($car['model'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></li>
    <li><strong>Energie :</strong> <?php echo html_entity_decode($car['energy'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></li>
    <li><strong>Couleur :</strong> <?php echo html_entity_decode($car['color'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></li>
</ul>