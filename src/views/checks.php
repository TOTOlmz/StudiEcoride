<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?>
            <p style="color:red"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php elseif (!empty($success)): ?>
    <div class="success">
        <p style="color:green"><?= htmlspecialchars($success) ?></p>
    </div>
<?php endif; ?>