<div class="page-header">
    <h1><?= EMOJI['user'] ?> Edytuj Użytkownika: <?= htmlspecialchars($user['username']) ?></h1>
    <a href="/admin/listUsers" class="btn btn-outline-primary">Powrót do listy</a>
</div>

<form action="/admin/updateUser/<?= htmlspecialchars($user['id']) ?>" method="POST">
    <div class="form-group">
        <label for="username">Nazwa użytkownika:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Adres E-mail:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>
    <div class="form-group">
        <label for="role">Rola:</label>
        <select id="role" name="role">
            <?php foreach ($roles as $role): ?>
                <option value="<?= $role ?>" <?= ($user['role'] === $role) ? 'selected' : '' ?>>
                    <?= ucfirst($role) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Zapisz Zmiany</button>
</form>
