<?php
$errors = $errors ?? [];
$input = $input ?? [];
?>

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
