<div class="review-card">
    <div class="section">
        <img src="./assets/images/users/<?php echo html_entity_decode($review['user_photo'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?>" alt="Photo de <?php echo html_entity_decode($review['user_pseudo'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?>">
        <strong> <?php echo html_entity_decode($review['user_pseudo'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></strong>
    </div>

    <div class="section">
        <span class="rate"><?php echo htmlspecialchars($review['rate']); ?> ★</span>
        <?php echo html_entity_decode($review['commentary'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?>
    </div>
</div>