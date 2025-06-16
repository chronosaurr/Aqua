<div class="page-header">
    <h1><?= EMOJI['user'] ?> Zarządzanie Użytkownikami</h1>
    <a href="/admin" class="btn btn-outline-primary">Powrót do panelu</a>
</div>

<?php
if (isset($_GET['status']) && $_GET['status'] === 'updated') {
    echo '<div class="success-message">Dane użytkownika zostały zaktualizowane.</div>';
}

$headers = [
    'id' => 'ID',
    'username' => 'Nazwa użytkownika',
    'email' => 'Email',
    'role' => 'Rola',
    'created_at' => 'Data rejestracji'
];

$actions = [
    ['label' => 'Edytuj', 'url' => '/admin/editUser/{id}', 'class' => 'btn-outline-primary'],
];

TableHelper::render($headers, $users, $actions);
?>

