<?php
$ticket = $ticket ?? [];
?>

<?php require_once VIEW_PATH . '/partials/header.php'; ?>
<?php require_once VIEW_PATH . '/partials/navbar.php'; ?>

    <div class="page-header">
        <h1><?= EMOJI['ticket'] ?> Szczegóły Ticketu #<?= htmlspecialchars($ticket['id'] ?? 'N/A') ?></h1>
        <a href="/ticket/list" class="btn btn-outline-primary">Powrót do listy</a>
    </div>

    <div class="ticket-details">
        <p><strong>Tytuł:</strong> <?= htmlspecialchars($ticket['title'] ?? 'Brak') ?></p>
        <p><strong>Opis:</strong> <?= nl2br(htmlspecialchars($ticket['description'] ?? 'Brak')) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($ticket['status'] ?? 'Brak') ?></p>
        <p><strong>Priorytet:</strong> <?= htmlspecialchars($ticket['priority'] ?? 'Brak') ?></p>
        <p><strong>Dział ID:</strong> <?= htmlspecialchars($ticket['department_id'] ?? 'Brak') ?></p>
        <p><strong>Przypisany ID:</strong> <?= htmlspecialchars($ticket['assignee_id'] ?? 'Brak') ?></p>
        <p><strong>Termin:</strong> <?= htmlspecialchars($ticket['deadline_at'] ?? 'Brak') ?></p>
        <p><strong>Twórca ID:</strong> <?= htmlspecialchars($ticket['creator_id'] ?? 'Brak') ?></p>
        <p><strong>Utworzono:</strong> <?= htmlspecialchars($ticket['created_at'] ?? 'Brak') ?></p>
    </div>

<?php require_once VIEW_PATH . '/partials/footer.php'; ?>
