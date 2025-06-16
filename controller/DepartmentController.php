<?php
class DepartmentController extends BaseController {

    private Department $departmentModel;

    public function __construct() {
        $db = Database::getInstance();
        $this->departmentModel = new Department($db);
    }

    /**
     * Domyślna akcja, alias dla listy.
     */
    public function index(): void {
        $this->list();
    }

    /**
     * Wyświetla listę wszystkich departamentów.
     */
    public function list(): void {
        $departments = $this->departmentModel->findAll();

        $data = [
            'title' => 'Zarządzanie Działami',
            'activeController' => 'department',
            'departments' => $departments
        ];

        $this->renderView('department/list', $data);
    }

    /**
     * Wyświetla formularz do tworzenia nowego działu.
     */
    public function create(): void {
        $data = [
            'title' => 'Nowy Dział',
            'activeController' => 'department',
        ];
        $this->renderView('department/create', $data);
    }

    /**
     * Przetwarza dane z formularza i tworzy nowy dział.
     */
    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /department/create');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Nazwa działu jest wymagana.';
        }

        if (empty($errors)) {
            $this->departmentModel->create($name);

            header('Location: /department/list?status=created');
            exit;
        }

        $data = [
            'title' => 'Nowy Dział - Błąd',
            'activeController' => 'department',
            'errors' => $errors,
            'input' => ['name' => $name]
        ];
        $this->renderView('department/create', $data);
    }
}
