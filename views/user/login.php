<?php
$errors = $errors ?? [];
$input = $input ?? [];
?>

<h1><?= EMOJI['user'] ?> Zaloguj się</h1>

<?php if (isset($_GET['error']) && $_GET['error'] === 'invalid_credentials'): ?>
    <div class="error-message">Nieprawidłowy email lub hasło. Spróbuj ponownie.</div>
<?php endif; ?>

<?php if (isset($_GET['status']) && $_GET['status'] === 'registered'): ?>
    <div class="success-message">Rejestracja zakończona sukcesem! Możesz się teraz zalogować.</div>
<?php endif; ?>

<form action="/user/authenticate" method="POST">
    <div class="form-group">
        <label for="email">Adres E-mail:</label>
        <input type="email" id="email" name="email" required>
    </div>

    <div class="form-group">
        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required>
    </div>

    <button type="submit" class="submit-btn">Zaloguj</button>
</form>

<div class="link-to-register">
    <p>Nie masz jeszcze konta? <a href="/user/register">Zarejestruj się tutaj</a>.</p>
</div>

<?php if (isset($_GET['status']) && $_GET['status'] === 'login_required'): ?>
    <div class="error-message">Musisz być zalogowany, aby uzyskać dostęp do tej strony.</div>
<?php endif; ?>