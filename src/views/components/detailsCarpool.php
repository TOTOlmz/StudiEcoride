
<span><strong>Date :</strong> <?php echo $carpool['date']; ?></span>
<span><strong>Départ :</strong> <?php echo html_entity_decode($carpool['departure_city'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?> à <strong><?php echo htmlspecialchars($carpool['departure_time']); ?></strong></span>
<span><strong>Arrivée :</strong> <?php echo html_entity_decode($carpool['arrival_city'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?> à <strong><?php echo htmlspecialchars($carpool['arrival_time']); ?></strong></span>
<span><strong>Durée :</strong> <?php echo $carpool['duration']; ?></span>
<span><strong>Prix :</strong> <strong><?php echo htmlspecialchars($carpool['price']); ?> crédits</strong></span>
<span><strong>Places disponibles :</strong> <strong><?php echo htmlspecialchars($carpool['available_seats']); ?></strong></span>
<span><strong>Écologique :</strong> <?php echo intval($carpool['is_ecological']) ? '<span class="green">Oui</span>' : '<span class="red">Non</span>'; ?></span>
<span><strong>Animaux acceptés :</strong> <?php echo intval($carpool['animals']) ? '<span class="green">Oui</span>' : '<span class="red">Non</span>'; ?></span>
<span><strong>Fumeurs acceptés :</strong> <?php echo intval($carpool['smoke']) ? '<span class="green">Oui</span>' : '<span class="red">Non</span>'; ?></span>
<span><strong>Préférences :</strong> <em><?php echo html_entity_decode($carpool['preferences'], ENT_QUOTES | ENT_HTML5, 'UTF-8') ?: 'Aucune préférence particulière'; ?></em></span>
