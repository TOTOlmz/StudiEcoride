

<div>
    <div class="infos">
        <span>Covoiturage #<?php echo $report['carpool_id'] ?></span>
    
        <p><strong>Emetteur :</strong> <?php echo html_entity_decode($report['user_pseudo'], ENT_QUOTES | ENT_HTML5, 'UTF-8') ?>  <br> Email :  
        <a href="mailto:<?php echo html_entity_decode($report['user_email'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?>"><?php echo html_entity_decode($report['user_email']); ?></a></p>
        <p><strong>Conducteur :</strong> <?php echo html_entity_decode($report['driver_pseudo'], ENT_QUOTES | ENT_HTML5, 'UTF-8') ?> <br> Email : 
        <a href="mailto:<?php echo html_entity_decode($report['driver_email'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?>"><?php echo html_entity_decode($report['driver_email'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></a></p>
        <p><strong>Trajet en date du :</strong> <?php echo html_entity_decode($report['date-fr']); ?></p>
        
        <p><strong>Départ :</strong> <?php echo html_entity_decode($report['departure_city'], ENT_QUOTES | ENT_HTML5, 'UTF-8') ?> à <?php echo html_entity_decode($report['departure_time'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></p>
        <p><strong>Arrivée :</strong> <?php echo html_entity_decode($report['arrival_city'], ENT_QUOTES | ENT_HTML5, 'UTF-8') ?> à <?php echo html_entity_decode($report['arrival_time'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></p>
        <p><strong>Objet :</strong> <?php echo html_entity_decode($report['subject'], ENT_QUOTES | ENT_HTML5, 'UTF-8') ?></p>
        <p><strong>Description :</strong> <?php echo html_entity_decode($report['description'], ENT_QUOTES | ENT_HTML5, 'UTF-8') ?></p>
    </div>
</div>