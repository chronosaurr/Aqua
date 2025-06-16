<?php

$errors = $errors ?? [];
$input = $input ?? [];
?>

<div class="page-header">
    <h1><?= EMOJI['department'] ?> Dodaj Nowy Dział</h1>
    <a href="/department/list" class="btn btn-outline-primary">Powrót do listy</a>
</div>

<form action="/department/store" method="POST">
    <div class="form-group">
        <label for="name">Nazwa działu:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($input['name'] ?? '') ?>" required autofocus>
        <?php if (isset($errors['name'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['name']) ?></div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Zapisz Dział</button>
</form>