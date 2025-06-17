<?php

class AdminController extends BaseController {

    private User $userModel;
    public function __construct() {
        parent::__construct();
        $this->requireRole('admin');

        $this->userModel = $this->loadModel('User');
    }

    /**
     * Wyświetla główny widok panelu administratora.
     */
    public function index(): void {
        $data = [
            'title' => 'Panel Administratora',
            'activeController' => 'admin'
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
     * Wyświetla formularz dodawania nowego użytkownika.
     */
    public function addUser(): void {
        $data = [
            'title' => 'Dodaj Nowego Użytkownika',
            'activeController' => 'admin',
            'roles' => ['user', 'owner', 'admin'],
            'errors' => [],
            'input' => []
        ];
        $this->renderView('admin/addUser', $data);
    }

    /**
     * Przetwarza dane z formularza dodawania użytkownika i tworzy nowego.
     */
    public function storeUser(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/addUser');
            exit;
        }

        $input = [
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
            'role' => $_POST['role'] ?? 'user'
        ];

        $errors = [];

        // Walidacja pól
        if (empty($input['username'])) {
            $errors['username'] = 'Nazwa użytkownika jest wymagana.';
        } elseif ($this->userModel->findByUsername($input['username'])) {
            $errors['username'] = 'Nazwa użytkownika jest już zajęta.';
        }

        if (empty($input['email'])) {
            $errors['email'] = 'Adres email jest wymagany.';
        } elseif (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Nieprawidłowy format adresu email.';
        } elseif ($this->userModel->findByEmail($input['email'])) {
            $errors['email'] = 'Adres email jest już zajęty.';
        }

        if (empty($input['password'])) {
            $errors['password'] = 'Hasło jest wymagane.';
        } elseif (strlen($input['password']) < 6) {
            $errors['password'] = 'Hasło musi mieć co najmniej 6 znaków.';
        }

        if ($input['password'] !== $input['password_confirm']) {
            $errors['password_confirm'] = 'Hasła nie są identyczne.';
        }

        $allowedRoles = ['user', 'owner', 'admin'];
        if (!in_array($input['role'], $allowedRoles)) {
            $errors['role'] = 'Nieprawidłowa rola.';
        }

        if (empty($errors)) {
            if ($this->userModel->create($input)) {
                header('Location: /admin/listUsers?status=user_created');
                exit;
            } else {
                $errors['form'] = 'Wystąpił błąd podczas tworzenia użytkownika.';
            }
        }

        $data = [
            'title' => 'Dodaj Nowego Użytkownika - Błąd',
            'activeController' => 'admin',
            'roles' => $allowedRoles,
            'errors' => $errors,
            'input' => $input
        ];
        $this->renderView('admin/addUser', $data);
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
            'roles' => ['user', 'owner', 'admin'],
            'errors' => [],
            'input' => $user
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

        $errors = [];
        $currentUser = $this->userModel->findById($id);
        $loggedInUserId = Auth::getUserId();
        $loggedInUserRole = Auth::getRole();

        if (!$currentUser) {
            http_response_code(404);
            $this->renderView('errors/404');
            return;
        }
        // Walidacja jesli zmienione cos
        if ($input['username'] !== $currentUser['username'] && $this->userModel->findByUsername($input['username'])) {
            $errors['username'] = 'Nazwa użytkownika jest już zajęta.';
        }
        if ($input['email'] !== $currentUser['email'] && $this->userModel->findByEmail($input['email'])) {
            $errors['email'] = 'Adres email jest już zajęty.';
        }
        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Nieprawidłowy format adresu email.';
        }

        // Walidacja roli
        $allowedRoles = ['user', 'owner', 'admin'];
        if (!in_array($input['role'], $allowedRoles)) {
            $errors['role'] = 'Nieprawidłowa rola.';
        }

        if ($loggedInUserId === $id && $loggedInUserRole === 'admin' && $input['role'] !== 'admin') {
            $errors['role'] = 'Nie możesz zmienić własnej roli administratora na inną.';
        }

        if (empty($errors)) {
            if ($this->userModel->update($id, $input)) {
                header('Location: /admin/listUsers?status=updated');
                exit;
            } else {
                $errors['form'] = 'Wystąpił błąd podczas aktualizacji użytkownika.';
            }
        }

        $data = [
            'title' => 'Edytuj Użytkownika - Błąd',
            'activeController' => 'admin',
            'user' => array_merge($currentUser, ['username' => $input['username'], 'email' => $input['email'], 'role' => $input['role']]),
            'roles' => $allowedRoles,
            'errors' => $errors,
            'input' => $input
        ];
        $this->renderView('admin/editUser', $data);
    }

    /**
     * Usuwa użytkownika.
     */
    public function deleteUser(int $id): void {
        if (Auth::getUserId() === $id) {
            header('Location: /admin/listUsers?error=cannot_delete_self');
            exit;
        }

        $this->userModel->delete($id);

        header('Location: /admin/listUsers?status=user_deleted');
        exit;
    }
}