<div class="page-header">More actions
    <h1><?= EMOJI['department'] ?> Zarządzanie Działami</h1>
    <a href="/department/create" class="btn btn-primary">Dodaj Nowy Dział</a>
</div>

<?php if (isset($_GET['status']) && $_GET['status'] === 'created'): ?>
    <div class="success-message">Nowy dział został pomyślnie dodany.</div>
<?php endif; ?>

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