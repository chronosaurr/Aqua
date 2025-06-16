<?php

// autoloader to robi
// require_once CONTROLLER_PATH . '/BaseController.php';
// require_once MODEL_PATH . '/User.php';
// require_once CORE_PATH . '/Auth.php';

class UserController extends BaseController {

    private User $userModel;

    public function __construct() {
        $dbConnection = Database::getInstance()->getConnection();
        $this->userModel = new User($dbConnection);
    }

    // Wyświetla formularz logowania.
    public function login(): void {
        $data = [
            'title' => 'Logowanie',
            'activeController' => 'user'
        ];
        $this->renderView('user/login', $data);
    }

    //Wyświetla formularz rejestracji.
    public function register(): void {
        $data = [
            'title' => 'Rejestracja',
            'activeController' => 'user'
        ];
        $this->renderView('user/register', $data);
    }

    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /user/register');
            exit;
        }

        $errors = [];
        $input = [
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? ''
        ];

        if (empty($input['username'])) { $errors['username'] = 'Nazwa użytkownika jest wymagana.'; }
        if (empty($input['email'])) { $errors['email'] = 'Adres email jest wymagany.'; }
        elseif (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) { $errors['email'] = 'Nieprawidłowy format adresu email.';}
        if (empty($input['password'])) { $errors['password'] = 'Hasło jest wymagane.'; }
        if ($input['password'] !== $input['password_confirm']) { $errors['password_confirm'] = 'Hasła nie są identyczne.'; }

        if (empty($errors)) {
            if ($this->userModel->findByUsername($input['username'])) { $errors['username'] = 'Ta nazwa użytkownika jest już zajęta.'; }
            if ($this->userModel->findByEmail($input['email'])) { $errors['email'] = 'Ten adres email jest już używany.'; }
        }

        if (empty($errors)) {
            $success = $this->userModel->create($input);
            if ($success) {
                header('Location: /user/login?status=registered');
                exit;
            } else {
                $errors['form'] = 'Wystąpił błąd podczas rejestracji. Spróbuj ponownie.';
            }
        }

        $data = [
            'title' => 'Rejestracja - Błąd',
            'activeController' => 'user',
            'errors' => $errors,
            'input' => $input
        ];
        $this->renderView('user/register', $data);
    }

    //Uwierzytelnia użytkownika na podstawie danych z formularza logowania.
    public function authenticate(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /user/login');
            exit;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->login($email, $password);

        if ($user) {
            Auth::login($user['id'], $user['username'], $user['role']);

            header('Location: /dashboard');
            exit;
        } else {
            header('Location: /user/login?error=invalid_credentials');
            exit;
        }
    }
}