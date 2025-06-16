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
}