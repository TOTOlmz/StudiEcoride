<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php elseif (!empty($success)): ?>
    <div class="success">
        <p><?= htmlspecialchars($success) ?></p>
    </div>
<?php endif; ?>