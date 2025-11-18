<ul class="detail-card">
    <li style="text-align: center; margin-bottom: 1rem;">
        <img src="../src/assets/images/users/<?php echo htmlspecialchars($driver['photo']); ?>" 
             alt="photo conducteur" 
             style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #196e44;">
    </li>
    <li><strong>Pseudo :</strong> <?php echo htmlspecialchars($driver['pseudo']); ?></li>
    <li><strong>Email :</strong> <?php echo htmlspecialchars($driver['email']); ?></li>
    <li><strong>Note moyenne :</strong> 
        <span style="font-size: 1.1em;">
            <?php echo $driver['avg'] !== null ? $driver['avg'] . ' ⭐' : 'Non noté'; ?>
        </span>
    </li>
    <?php if ($driverComments && count($driverComments) > 0): ?>
        <li><strong>Commentaires :</strong>
            <div style="margin-top: 0.5rem;">
                <?php foreach ($driverComments as $comment): ?>
                    <div style="background: #f3eee1; padding: 0.8rem; margin: 0.5rem 0; border-radius: 8px; border-left: 4px solid #196e44;">
                        <p style="margin: 0 0 0.5rem 0; font-style: italic;"><?php echo html_entity_decode($comment['commentary'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></p>
                        <p style="margin: 0; font-weight: bold; color: #196e44;"><?php echo intval($comment['rate']); ?>⭐</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </li>
    <?php else: ?>
        <li><em style="color: #666;">Aucun commentaire pour ce conducteur.</em></li>
    <?php endif; ?>
</ul>