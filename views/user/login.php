<?php
$errors = $errors ?? [];
$input = $input ?? [];
?>

<style>
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
    .form-group input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
    .error-message { color: #D8000C; background-color: #FFD2D2; padding: 5px; border-radius: 3px; font-size: 0.9em; margin-top: 5px;}
    .success-message { color: #2F652F; background-color: #DFF2BF; padding: 5px; border-radius: 3px; font-size: 0.9em; margin-bottom: 10px;}
    .submit-btn { background-color: var(--primary-green); color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; }
    .submit-btn:hover { background-color: var(--primary-green-dark); }
    .link-to-register { margin-top: 15px; }
</style>

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