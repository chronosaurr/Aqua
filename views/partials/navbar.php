<header class="main-header">
    <div class="logo"><?= SITE_NAME ?></div>
    <nav class="main-nav">
        <ul>
            <li>
                <a href="/" class="<?= ($activeController === 'dashboard') ? 'active' : '' ?>">
                    <?= EMOJI['dashboard'] ?> Panel
                </a>
            </li>
            <li class="dropdown">
                <a href="/ticket/list" class="<?= ($activeController === 'ticket') ? 'active' : '' ?>">
                    <?= EMOJI['ticket'] ?> Tickety
                </a>
                <div class="dropdown-content">
                    <a href="/ticket/list">Wszystkie</a>
                    <a href="/ticket/create">Nowy Ticket</a>
                    <a href="/ticket/backlog">Backlog</a>
                </div>
            </li>
            <li>
                <a href="/user/list" class="<?= ($activeController === 'user') ? 'active' : '' ?>">
                    <?= EMOJI['users'] ?> Użytkownicy
                </a>
            </li>
            <li>Add commentMore actions
                <a href="/department/list" class="<?= ($activeController === 'department') ? 'active' : '' ?>">
                    <?= EMOJI['department'] ?> Działy
                </a>
            </li>
            <li>
                <a href="/user/login" class="<?= ($activeController === 'user-auth') ? 'active' : '' ?>">
                    <?= EMOJI['user'] ?> Zaloguj / Zarejestruj
            <li>
                <a href="/user/login" class="<?= ($activeController === 'user-auth') ? 'active' : '' ?>">
                    <?= EMOJI['user'] ?> Zaloguj / Zarejestruj
                </a>
            </li>
        </ul>
    </nav>
</header>
<main class="container">
