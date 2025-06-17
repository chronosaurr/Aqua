<?php

class TicketController extends BaseController {

    private Ticket $ticketModel;
    private Department $departmentModel;
    private User $userModel;
    private Attachment $attachmentModel;

    public function __construct() {
        //Wszystkie akcje TicketController wymagają zalogowania
        $this->requireAuth();

        $db = Database::getInstance();

        $this->ticketModel = new Ticket($db);
        $this->departmentModel = new Department($db);
        $this->userModel = new User($db);
        $this->attachmentModel = new Attachment($db);
    }

    /**
     * Domyślna akcja, alias dla listy.
     */
    public function index(): void {
        $this->list();
    }

    /**
     * Wyświetla listę wszystkich ticketów.
     */
    public function list(): void {
        $tickets = $this->ticketModel->findAll();

        $data = [
            'title' => 'Wszystkie Tickety',
            'activeController' => 'ticket',
            'tickets' => $tickets
        ];

        $this->renderView('ticket/list', $data);
    }

    /**
     * Wyświetla formularz do tworzenia nowego ticketu.
     */
    public function create(): void {
        $data = [
            'title' => 'Nowy Ticket',
            'activeController' => 'ticket',
            'departments' => $this->departmentModel->findAll(),
            'users' => $this->userModel->findAll(),
            'errors' => [],
            'input' => []
        ];

        $this->renderView('ticket/create', $data);
    }

    /**
     * Przetwarza dane z formularza i tworzy nowy ticket, w tym załączniki.
     */
    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ticket/create');
            exit;
        }

        $errors = [];
        $input = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'priority' => $_POST['priority'] ?? '',
            'department_id' => (int)($_POST['department_id'] ?? 0),
            'assignee_id' => (int)($_POST['assignee_id'] ?? 0),
            'deadline_at' => trim($_POST['deadline_at'] ?? ''),
            'creator_id' => Auth::getUserId()
        ];

        // --- Walidacja Danych ---
        if (empty($input['title'])) {
            $errors['title'] = 'Tytuł jest wymagany.';
        }
        if (empty($input['description'])) {
            $errors['description'] = 'Opis jest wymagany.';
        }

        $allowedPriorities = ['niski', 'średni', 'wysoki'];
        if (!in_array($input['priority'], $allowedPriorities)) {
            $errors['priority'] = 'Nieprawidłowy priorytet.';
        }

        if ($input['department_id'] <= 0 || !$this->departmentModel->findById($input['department_id'])) {
            $errors['department_id'] = 'Wybierz prawidłowy dział.';
        }

        if ($input['assignee_id'] > 0 && !$this->userModel->findById($input['assignee_id'])) {
            $errors['assignee_id'] = 'Nieprawidłowy użytkownik do przypisania.';
        } else if ($input['assignee_id'] === 0) {
            $input['assignee_id'] = null;
        }

        if (!empty($input['deadline_at'])) {
            if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $input['deadline_at'])) {
                $errors['deadline_at'] = 'Nieprawidłowy format daty (YYYY-MM-DD).';
            } else {
                try {
                    new DateTime($input['deadline_at']);
                } catch (Exception $e) {
                    $errors['deadline_at'] = 'Nieprawidłowa data.';
                }
            }
        } else {
            $input['deadline_at'] = null;
        }

        $file = $_FILES['attachment'] ?? null;
        if ($file && $file['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors['attachment'] = 'Błąd przesyłania pliku: ' . $file['error'];
            } elseif ($file['size'] > 5 * 1024 * 1024) { // Limit 5MB
                $errors['attachment'] = 'Plik jest za duży (maks. 5MB).';
            } else {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->file($file['tmp_name']);
                $allowedMimeTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                if (!in_array($mimeType, $allowedMimeTypes)) {
                    $errors['attachment'] = 'Dozwolone formaty: JPG, PNG, PDF.';
                }
            }
        }

        // Jeśli nie ma błędów walidacji
        if (empty($errors)) {
            $dbConnection = Database::getInstance()->getConnection();
            try {
                $dbConnection->beginTransaction();

                $newTicketId = $this->ticketModel->create($input);

                if ($file && $file['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = ROOT_PATH . '/public/uploads/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    $originalName = basename($file['name']);
                    $storedName = uniqid('file_', true) . '.' . pathinfo($originalName, PATHINFO_EXTENSION);

                    if (move_uploaded_file($file['tmp_name'], $uploadDir . $storedName)) {
                        $attachmentData = [
                            'original_filename' => $originalName,
                            'stored_filename' => $storedName,
                            'filesize' => $file['size']
                        ];
                        $this->attachmentModel->create($newTicketId, $attachmentData);
                    } else {
                        throw new Exception('Nie udało się zapisać załącznika na serwerze.');
                    }
                }

                $dbConnection->commit();
                header('Location: /ticket/list?status=ticket_created');
                exit;

            } catch (Exception $e) {
                $dbConnection->rollBack();
                error_log("Błąd tworzenia ticketu z załącznikiem: " . $e->getMessage());
                $errors['form'] = 'Wystąpił błąd podczas tworzenia ticketu. Spróbuj ponownie.';
            }
        }

        $data = [
            'title' => 'Nowy Ticket - Błąd',
            'activeController' => 'ticket',
            'departments' => $this->departmentModel->findAll(),
            'users' => $this->userModel->findAll(),
            'errors' => $errors,
            'input' => $input
        ];
        $this->renderView('ticket/create', $data);
    }

    /**
     * Wyświetla szczegóły pojedynczego ticketu.
     */
    public function show(int $id): void {
        $ticket = $this->ticketModel->findById($id);

        if (!$ticket) {
            http_response_code(404);
            $this->renderView('errors/404');
            return;
        }

        // $attachments = $this->attachmentModel->findByTicketId($id);
        // $comments = $this->commentModel->findByTicketId($id);

        $data = [
            'title' => 'Ticket #' . $ticket['id'],
            'activeController' => 'ticket',
            'ticket' => $ticket,
            // 'attachments' => $attachments,
            // 'comments' => $comments,
        ];
        $this->renderView('ticket/show', $data);
    }

    /**
     * Wyświetla formularz edycji ticketu.
     */
    public function edit(int $id): void {
        $ticket = $this->ticketModel->findById($id);

        if (!$ticket) {
            http_response_code(404);
            $this->renderView('errors/404');
            return;
        }

        $data = [
            'title' => 'Edytuj Ticket #' . $ticket['id'],
            'activeController' => 'ticket',
            'ticket' => $ticket,
            'departments' => $this->departmentModel->findAll(),
            'users' => $this->userModel->findAll(),
            'errors' => [],
            'input' => $ticket
        ];
        $this->renderView('ticket/edit', $data);
    }

    /**
     * Przetwarza dane z formularza edycji i aktualizuje ticket.
     */
    public function update(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ticket/list');
            exit;
        }

        $input = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'status' => $_POST['status'] ?? '',
            'priority' => $_POST['priority'] ?? '',
            'department_id' => (int)($_POST['department_id'] ?? 0),
            'assignee_id' => (int)($_POST['assignee_id'] ?? 0),
            'deadline_at' => trim($_POST['deadline_at'] ?? ''),
        ];

        $errors = [];
        $currentTicket = $this->ticketModel->findById($id);

        if (!$currentTicket) {
            http_response_code(404);
            $this->renderView('errors/404');
            return;
        }

        if (empty($input['title'])) { $errors['title'] = 'Tytuł jest wymagany.'; }
        if (empty($input['description'])) { $errors['description'] = 'Opis jest wymagany.'; }

        $allowedPriorities = ['niski', 'średni', 'wysoki'];
        if (!in_array($input['priority'], $allowedPriorities)) { $errors['priority'] = 'Nieprawidłowy priorytet.'; }

        $allowedStatuses = ['otwarty', 'w_toku', 'zamknięty', 'oczekujący']; // Przykładowe statusy
        if (!in_array($input['status'], $allowedStatuses)) { $errors['status'] = 'Nieprawidłowy status.'; }

        if ($input['department_id'] <= 0 || !$this->departmentModel->findById($input['department_id'])) {
            $errors['department_id'] = 'Wybierz prawidłowy dział.';
        }
        if ($input['assignee_id'] > 0 && !$this->userModel->findById($input['assignee_id'])) {
            $errors['assignee_id'] = 'Nieprawidłowy użytkownik do przypisania.';
        } else if ($input['assignee_id'] === 0) {
            $input['assignee_id'] = null;
        }

        if (!empty($input['deadline_at'])) {
            if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $input['deadline_at'])) {
                $errors['deadline_at'] = 'Nieprawidłowy format daty (YYYY-MM-DD).';
            } else {
                try { new DateTime($input['deadline_at']); } catch (Exception $e) { $errors['deadline_at'] = 'Nieprawidłowa data.'; }
            }
        } else {
            $input['deadline_at'] = null;
        }

        if (empty($errors)) {
            if ($this->ticketModel->update($id, $input)) {
                header('Location: /ticket/list?status=ticket_updated');
                exit;
            } else {
                $errors['form'] = 'Wystąpił błąd podczas aktualizacji ticketu.';
            }
        }

        $data = [
            'title' => 'Edytuj Ticket - Błąd',
            'activeController' => 'ticket',
            'ticket' => array_merge($currentTicket, $input),
            'departments' => $this->departmentModel->findAll(),
            'users' => $this->userModel->findAll(),
            'errors' => $errors,
            'input' => $input
        ];
        $this->renderView('ticket/edit', $data);
    }

    /**
     * Usuwa ticket.
     */
    public function delete(int $id): void {
        $ticket = $this->ticketModel->findById($id);

        if (!$ticket) {
            http_response_code(404);
            $this->renderView('errors/404');
            return;
        }

        $currentUser = Auth::getUserId();
        $currentUserRole = Auth::getRole();


        if ($currentUserRole !== 'admin' && $currentUser !== $ticket['creator_id']) {
            http_response_code(403);
            $this->renderView('errors/403');
            exit;
        }

        $dbConnection = Database::getInstance()->getConnection();
        try {
            $dbConnection->beginTransaction();

            $attachments = $this->attachmentModel->findByTicketId($id);
            foreach ($attachments as $attachment) {
                $filePath = ROOT_PATH . '/public/uploads/' . $attachment['stored_filename'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $this->attachmentModel->delete($attachment['id']);
            }

            // if (isset($this->commentModel)) {
            //     $this->commentModel->deleteByTicketId($id);
            // }

            $this->ticketModel->delete($id);

            $dbConnection->commit();
            header('Location: /ticket/list?status=ticket_deleted');
            exit;

        } catch (Exception $e) {
            $dbConnection->rollBack();
            error_log("Błąd usuwania ticketu i załączników: " . $e->getMessage());
            header('Location: /ticket/list?error=delete_failed');
            exit;
        }
    }
}