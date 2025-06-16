<?php
$errors = $errors ?? [];
$input = $input ?? [];
$roles = ['admin', 'user', 'owner'];
?>

<?php require_once VIEW_PATH . '/partials/header.php'; ?>
<?php require_once VIEW_PATH . '/partials/navbar.php'; ?>

    <div class="page-header">
        <h1><?= EMOJI['user_add'] ?> Dodaj Użytkownika</h1>
        <a href="/admin/users" class="btn btn-outline-primary">Powrót do listy użytkowników</a>
    </div>

<?php if (isset($errors['form'])): ?>
    <div class="error-message"><?= htmlspecialchars($errors['form']) ?></div>
<?php endif; ?>

    <form action="/admin/storeUser" method="POST">
        <div class="form-group">
            <label for="username">Nazwa użytkownika:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($input['username'] ?? '') ?>" required>
            <?php if (isset($errors['username'])): ?>
                <div class="error-message"><?= htmlspecialchars($errors['username']) ?></div>
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
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($input['email'] ?? '') ?>" required>
            <?php if (isset($errors['email'])): ?>
                <div class="error-message"><?= htmlspecialchars($errors['email']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="role">Rola:</label>
            <select id="role" name="role" required>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= $role ?>" <?= (isset($input['role']) && $input['role'] === $role) ? 'selected' : '' ?>><?= ucfirst($role) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['role'])): ?>
                <div class="error-message"><?= htmlspecialchars($errors['role']) ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Dodaj</button>
    </form>

<?php require_once VIEW_PATH . '/partials/footer.php'; ?>

