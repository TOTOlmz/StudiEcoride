
<div class="driver-infos">
    <img class="profile-picture"
    src="<?php echo isset($driver['photo']) ? './assets/images/users/' . html_entity_decode($driver['photo'], ENT_QUOTES | ENT_HTML5, 'UTF-8') : '../src/assets/images/users/default.png'; ?>"
    alt="Photo de profil"/>
    <div>
        <p><strong><?php echo ucfirst(html_entity_decode($driver['pseudo'], ENT_QUOTES | ENT_HTML5, 'UTF-8')); ?></strong></p>
    </div>
</div>

<div class="driver-avg"><strong>Note moyenne :</strong> 
    <span>
        <?php echo $driver['avg'] !== null ? $driver['avg'] . ' ★' : 'Non noté'; ?>
    </span>
</div>
<div class="driver-comments">
<?php if ($driverComments && count($driverComments) > 0): ?>
    <strong>Commentaires :</strong>
    <div class="driver-review-cards">
        <?php foreach ($driverComments as $comment): ?>
            <div class="review-card">
                <p class="rate"><?php echo intval($comment['rate']); ?>★</p>
                <p><?php echo html_entity_decode($comment['commentary'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>
    <em>Aucun commentaire pour ce conducteur.</em>
<?php endif; ?>