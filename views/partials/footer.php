</main>
<footer class="main-footer">
    <div class="footer-content">
        <div class="user-info">
            <?php if (Auth::isLoggedIn()): ?>
                <?= EMOJI['user'] ?> Zalogowany jako: <strong><?= htmlspecialchars(Auth::getUsername()) ?></strong>
            <?php endif; ?>
        </div>
        <div class="stats">
            <?php
            global $startTime;
            $executionTime = microtime(true) - $startTime;
            $memoryUsage = memory_get_peak_usage(true) / 1024 / 1024;
            //staty z bazy danych
            $queryCount = Database::getQueryCount();
            $totalQueryTime = Database::getTotalQueryTime();
            ?>
            <span><?= EMOJI['database'] ?> Zapytania: <?= $queryCount ?> (<?= number_format($totalQueryTime * 1000, 2) ?> ms)</span> |
            <span><?= EMOJI['php'] ?> <?= PHP_VERSION ?></span> |
            <span><?= EMOJI['clock']?> Czas: <?= number_format($executionTime, 4) ?>s</span> |
            <span><?= EMOJI['memory']?> Pamięć: <?= number_format($memoryUsage, 2) ?> MB</span>
        </div>
</footer>
</body>
</html>
