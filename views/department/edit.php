<?php
$errors = $errors ?? [];
?>

<div class="page-header">
    <h1><?= EMOJI['department'] ?> Edytuj Dział: <?= htmlspecialchars($department['name']) ?></h1>
    <a href="/department/list" class="btn btn-outline-primary">Powrót do listy</a>
</div>

<form action="/department/update/<?= htmlspecialchars($department['id']) ?>" method="POST">
    <div class="form-group">
        <label for="name">Nowa nazwa działu:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($department['name'] ?? '') ?>" required autofocus>
        <?php if (isset($errors['name'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['name']) ?></div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Zapisz Zmiany</button>
</form>