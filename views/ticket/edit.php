<?php
$errors = $errors ?? [];
$input = $input ?? [];
$ticket = $ticket ?? [];
$departments = $departments ?? [];
$users = $users ?? [];
$current_attachments = $current_attachments ?? [];
?>

<?php require_once VIEW_PATH . '/partials/header.php'; ?>
<?php require_once VIEW_PATH . '/partials/navbar.php'; ?>

<div class="page-header">
    <h1><?= EMOJI['ticket'] ?> Edytuj Ticket #<?= htmlspecialchars($ticket['id'] ?? 'N/A') ?></h1>
    <a href="/ticket/list" class="btn btn-outline-primary">Powrót do listy</a>
</div>

<?php if (isset($errors['form'])): ?>
    <div class="error-message"><?= htmlspecialchars($errors['form']) ?></div>
<?php endif; ?>

<form action="/ticket/update/<?= htmlspecialchars($ticket['id'] ?? '') ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Tytuł:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($input['title'] ?? '') ?>" required>
        <?php if (isset($errors['title'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['title']) ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="description">Opis:</label>
        <textarea id="description" name="description" rows="5" required><?= htmlspecialchars($input['description'] ?? '') ?></textarea>
        <?php if (isset($errors['description'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['description']) ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <?php
            $statuses = ['otwarty', 'w_toku', 'zamknięty', 'oczekujący']; // Zgodne z kontrolerem
            foreach ($statuses as $statusOption):
                ?>
                <option value="<?= $statusOption ?>"
                    <?= (isset($input['status']) && $input['status'] === $statusOption) ? 'selected' : '' ?>>
                    <?= ucfirst(str_replace('_', ' ', $statusOption)) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['status'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['status']) ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="priority">Priorytet:</label>
        <select id="priority" name="priority" required>
            <option value="niski" <?= (isset($input['priority']) && $input['priority'] === 'niski') ? 'selected' : '' ?>>Niski</option>
            <option value="średni" <?= (isset($input['priority']) && $input['priority'] === 'średni') ? 'selected' : '' ?>>Średni</option>
            <option value="wysoki" <?= (isset($input['priority']) && $input['priority'] === 'wysoki') ? 'selected' : '' ?>>Wysoki</option>
        </select>
        <?php if (isset($errors['priority'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['priority']) ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="department_id">Dział:</label>
        <select id="department_id" name="department_id" required>
            <option value="">-- Wybierz Dział --</option>
            <?php foreach ($departments as $department): ?>
                <option value="<?= $department['id'] ?>" <?= (isset($input['department_id']) && (int)$input['department_id'] === $department['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($department['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['department_id'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['department_id']) ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="assignee_id">Przypisz do (opcjonalnie):</label>
        <select id="assignee_id" name="assignee_id">
            <option value="">-- Nikt --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>" <?= (isset($input['assignee_id']) && (int)$input['assignee_id'] === $user['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($user['username']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($errors['assignee_id'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['assignee_id']) ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="deadline_at">Termin wykonania (opcjonalnie):</label>
        <input type="date" id="deadline_at" name="deadline_at" value="<?= htmlspecialchars($input['deadline_at'] ?? '') ?>">
        <?php if (isset($errors['deadline_at'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['deadline_at']) ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Istniejące Załączniki:</label>
        <?php if (!empty($current_attachments)): ?>
            <ul class="attachment-list">
                <?php foreach ($current_attachments as $attachment): ?>
                    <li>
                        <a href="/uploads/<?= htmlspecialchars($attachment['stored_filename']) ?>" target="_blank">
                            <?= htmlspecialchars($attachment['original_filename']) ?> (<?= round($attachment['filesize'] / 1024, 1) ?> KB)
                        </a>
                        <input type="checkbox" name="attachments_to_delete[]" value="<?= $attachment['id'] ?>" id="delete_<?= $attachment['id'] ?>">
                        <label for="delete_<?= $attachment['id'] ?>" class="delete-checkbox-label">Usuń</label>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Brak istniejących załączników.</p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="attachment">Dodaj Nowy Załącznik (opcjonalnie):</label>
        <input type="file" id="attachment" name="attachment">
        <?php if (isset($errors['attachment'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['attachment']) ?></div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Zapisz Zmiany</button>
</form>
