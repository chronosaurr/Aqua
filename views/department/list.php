<div class="page-header">
    <h1><?= EMOJI['department'] ?> Zarządzanie Działami</h1>
    <a href="/department/create" class="btn btn-primary">Dodaj Nowy Dział</a>
</div>

<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] === 'created'): ?>
        <div class="success-message">Nowy dział został pomyślnie dodany.</div>
    <?php elseif ($_GET['status'] === 'updated'): ?>
        <div class="success-message">Nazwa działu została zaktualizowana.</div>
    <?php endif; ?>
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

