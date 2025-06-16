<div class="page-header">
    <h1><?= EMOJI['department'] ?> Zarządzanie Działami</h1>
    <a href="/department/create" class="btn btn-primary">Dodaj Nowy Dział</a>
</div>

<?php
$headers = [
    'id' => 'ID',
    'name' => 'Nazwa Działu'
];

$actions = [
    ['label' => 'Edytuj', 'url' => '/department/edit/{id}', 'class' => 'btn-outline-primary'],
    ['label' => 'Usuń', 'url' => '/department/delete/{id}', 'class' => 'btn-outline-danger'],
];


TableHelper::render($headers, $departments, $actions);
?>