<div class="page-header">
    <h1><?= EMOJI['ticket'] ?> Ticket #<?= htmlspecialchars($ticket['id'] ?? 'N/A') ?>: <?= htmlspecialchars($ticket['title'] ?? 'Brak') ?></h1>
    <div>
        <a href="/ticket/edit/<?= $ticket['id'] ?>" class="btn btn-outline-primary">Edytuj</a>
        <a href="/ticket/list" class="btn btn-outline-primary">Powrót do listy</a>
    </div>
</div>

<div class="ticket-container">
    <div class="ticket-details">
        <h3>Szczegóły Zgłoszenia</h3>
        <p><strong>Status:</strong> <span class="status-badge status-<?= strtolower($ticket['status']) ?>"><?= htmlspecialchars($ticket['status'] ?? 'Brak') ?></span></p>
        <p><strong>Priorytet:</strong> <?= htmlspecialchars($ticket['priority'] ?? 'Brak') ?></p>
        <p><strong>Dział:</strong> <?= htmlspecialchars($ticket['department_name'] ?? 'Brak') ?></p>
        <p><strong>Przypisany do:</strong> <?= htmlspecialchars($ticket['assignee_username'] ?? 'Nie przypisano') ?></p>
        <p><strong>Termin wykonania:</strong> <?= htmlspecialchars($ticket['deadline_at'] ?? 'Brak') ?></p>
        <hr>
        <p><strong>Opis:</strong></p>
        <div class="ticket-description">
            <?= nl2br(htmlspecialchars($ticket['description'] ?? 'Brak')) ?>
        </div>
        <hr>
        <p class="ticket-meta">
            Utworzony przez <strong><?= htmlspecialchars($ticket['creator_username'] ?? 'Brak') ?></strong>
            dnia <?= htmlspecialchars(date('d.m.Y H:i', strtotime($ticket['created_at'] ?? ''))) ?>
        </p>
    </div>

    <div class="ticket-sidebar">
        <?php if (!empty($attachments)): ?>
            <h3><span class="emoji-small"><?= EMOJI['attachment'] ?></span> Załączniki</h3>
            <ul class="attachment-list">
                <?php foreach ($attachments as $attachment): ?>
                    <li>
                        <a href="/uploads/<?= htmlspecialchars($attachment['stored_filename']) ?>" target="_blank">
                            <?= htmlspecialchars($attachment['original_filename']) ?> (<?= round($attachment['filesize'] / 1024, 1) ?> KB)
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>


<div class="comments-section" id="comments">
    <h3><span class="emoji-small">💬</span> Komentarze (<?= count($comments) ?>)</h3>
    
    <div class="comment-list">
        <?php if (empty($comments)): ?>
            <p>Brak komentarzy.</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-bubble <?= (Auth::getUserId() === $comment['user_id']) ? 'is-own-comment' : '' ?>">
                    <div class="comment-header">
                        <strong><?= htmlspecialchars($comment['user_username']) ?></strong>
                        <span class="comment-date"><?= htmlspecialchars(date('d.m.Y H:i', strtotime($comment['created_at']))) ?></span>
                    </div>
                    <div class="comment-content">
                        <?= nl2br(htmlspecialchars($comment['content'])) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="add-comment-form">
        <h4>Dodaj komentarz</h4>
        <form action="/comment/store" method="POST">
            <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($ticket['id']) ?>">
            <div class="form-group">
                <textarea name="content" rows="4" placeholder="Wpisz treść komentarza..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Dodaj</button>
        </form>
    </div>
</div>
