<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) . ' | ' : '' ?><?= SITE_NAME ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
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
                    <?= EMOJI['user'] ?> Użytkownicy
                </a>
            </li>
        </ul>
    </nav>
</header>Add commentMore actions
<main class="container">
