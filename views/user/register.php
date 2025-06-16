<?php
$errors = $errors ?? [];
$input = $input ?? [];
?>

<style>
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
    .form-group input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
    .error-message { color: #D8000C; background-color: #FFD2D2; padding: 5px; border-radius: 3px; font-size: 0.9em; margin-top: 5px;}
    .submit-btn { background-color: var(--primary-green); color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; }
    .submit-btn:hover { background-color: var(--primary-green-dark); }
</style>

<h1><?= EMOJI['user'] ?> Stwórz Nowe Konto</h1>

<?php if (isset($errors['form'])): ?>
    <div class="error-message"><?= htmlspecialchars($errors['form']) ?></div>
<?php endif; ?>

<form action="/user/store" method="POST">
    <div class="form-group">
        <label for="username">Nazwa użytkownika:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($input['username'] ?? '') ?>" required>
        <?php if (isset($errors['username'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['username']) ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="email">Adres E-mail:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($input['email'] ?? '') ?>" required>
        <?php if (isset($errors['email'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['email']) ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required>
        <?php if (isset($errors['password'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['password']) ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="password_confirm">Potwierdź hasło:</label>
        <input type="password" id="password_confirm" name="password_confirm" required>
        <?php if (isset($errors['password_confirm'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['password_confirm']) ?></div>
        <?php endif; ?>
    </div>

    <button type="submit" class="submit-btn">Zarejestruj się</button>
</form>
