</main>
<footer class="main-footer">
    <?php
    // zmienne musza byc zdefiniowane w pliku, kotry dolacza stopke (aka w routerze)
    global $startTime;
    $executionTime = microtime(true) - $startTime;
    $memoryUsage = memory_get_peak_usage(true) / 1024 / 1024; // w MB
    ?>
    <div class="stats">
        <span>Wersja PHP: <?= PHP_VERSION ?></span> |
        <span>Czas generowania: <?= number_format($executionTime, 4) ?>s</span> |
        <span>Zużycie pamięci: <?= number_format($memoryUsage, 2) ?> MB</span>
    </div>
</footer>
</body>
</html>
