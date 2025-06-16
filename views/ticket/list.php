<h1><?= EMOJI['ticket'] ?> Lista Wszystkich Ticketów</h1>
<p>Ta strona wyświetla wszystkie zadania w systemie.</p>Add commentMore actions

<?php

$headers = [
    'id' => 'ID',
    'title' => 'Tytuł',
    'status' => 'Status',
    'priority' => 'Priorytet'
];

$actions = [
    ['label' => 'Zobacz', 'url' => '/ticket/show/{id}', 'class' => 'btn-outline-primary'],
    ['label' => 'Edytuj', 'url' => '/ticket/edit/{id}', 'class' => 'btn-outline-primary'],
    ['label' => 'Usuń', 'url' => '/ticket/delete/{id}', 'class' => 'btn-outline-danger'],
];

TableHelper::render($headers, $tickets, $actions);
?>