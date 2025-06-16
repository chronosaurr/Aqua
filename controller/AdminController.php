<?php

class AdminController extends BaseController {

    private User $userModel;

    public function __construct() {
    }

    /**
     * Wyświetla główny widok panelu administratora.
     */
    public function index(): void {
        $data = [
            'title' => 'Panel Administratora',
            'activeController' => 'admin' // Do podświetlenia menu
        ];

        $this->renderView('admin/dashboard', $data);
    }

    /**
     * Wyświetla listę wszystkich użytkowników.
     */
    public function listUsers(): void {
        $data = [
            'title' => 'Zarządzanie Użytkownikami',
            'activeController' => 'admin',
            'users' => $this->userModel->findAll()
        ];
        $this->renderView('admin/listUsers', $data);
    }

    /**
     * Wyświetla formularz edycji użytkownika.
     */
    public function editUser(int $id): void {
        $user = $this->userModel->findById($id);
        if (!$user) {
            http_response_code(404);
            $this->renderView('errors/404');
            return;
        }

        $data = [
            'title' => 'Edytuj Użytkownika',
            'activeController' => 'admin',
            'user' => $user,
            'roles' => ['user', 'owner', 'admin']
        ];
        $this->renderView('admin/editUser', $data);
    }

    /**
     * Przetwarza dane z formularza edycji użytkownika.
     */
    public function updateUser(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/listUsers');
            exit;
        }

        $input = [
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'role' => $_POST['role'] ?? ''
        ];

        $this->userModel->update($id, $input);

        header('Location: /admin/listUsers?status=updated');
        exit;
    }
}
