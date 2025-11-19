
<ul class="carpool-card">
    <li><strong>Date :</strong> <?php echo $carpool['date']; ?></li>
    <li><strong>Départ :</strong> <?php echo html_entity_decode($carpool['departure_city'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?> à <span style="color: #196e44; font-weight: bold;"><?php echo htmlspecialchars($carpool['departure_time']); ?></span></li>
    <li><strong>Arrivée :</strong> <?php echo html_entity_decode($carpool['arrival_city'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?> à <span style="color: #196e44; font-weight: bold;"><?php echo htmlspecialchars($carpool['arrival_time']); ?></span></li>
    <li><strong>⏱Durée :</strong> <?php echo $carpool['duration']; ?></li>
    <li><strong>Prix :</strong> <span style="color: #196e44; font-weight: bold; font-size: 1.1em;"><?php echo htmlspecialchars($carpool['price']); ?> crédits</span></li>
    <li><strong>Places disponibles :</strong> <span style="color: #196e44; font-weight: bold;"><?php echo htmlspecialchars($carpool['available_seats']); ?></span></li>
    <li><strong>Écologique :</strong> <?php echo intval($carpool['is_ecological']) ? '<span style="color: #196e44;">Oui</span>' : '<span style="color: #a50000;">Non</span>'; ?></li>
    <li><strong>Animaux acceptés :</strong> <?php echo intval($carpool['animals']) ? '<span style="color: #196e44;">Oui</span>' : '<span style="color: #a50000;">Non</span>'; ?></li>
    <li><strong>Fumeurs acceptés :</strong> <?php echo intval($carpool['smoke']) ? '<span style="color: #196e44;">Oui</span>' : '<span style="color: #a50000;">Non</span>'; ?></li>
    <li><strong>Préférences :</strong> <em><?php echo html_entity_decode($carpool['preferences'], ENT_QUOTES | ENT_HTML5, 'UTF-8') ?: 'Aucune préférence particulière'; ?></em></li>
</ul>