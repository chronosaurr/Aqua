<?php

abstract class BaseController {

    /**
     * Renderuje kompletny widok poprzez dołączenie nagłówka, stopki i pliku widoku.
     *
     * @param string $viewName Nazwa widoku do wczytania (np. 'dashboard/index')
     * @param array $data Dane do przekazania do widoku (stają się zmiennymi)
     */
    protected function renderView(string $viewName, array $data = []): void {
        extract($data);

        require_once VIEW_PATH . '/partials/header.php';
        require_once VIEW_PATH . '/partials/navbar.php';
        require_once VIEW_PATH . '/' . $viewName . '.php';
        require_once VIEW_PATH . '/partials/footer.php';
    }

    /**
     * ładuje instancję modelu na żądanie.
     * Zamiast tworzyć wszystkie modele w konstruktorze, tworzymy je tylko wtedy, gdy są potrzebne.
     *
     * @param string $modelName Nazwa klasy modelu (np. 'User', 'Ticket').
     * @return object Instancja żądanego modelu.
     * @throws Exception Jeśli klasa modelu nie istnieje.
     */
    protected function loadModel(string $modelName): object {
        if (!class_exists($modelName)) {
            throw new Exception("Model class '{$modelName}' not found.");
        }

        $db = Database::getInstance();
        return new $modelName($db);
    }

    /**
     * Sprawdza, czy użytkownik jest zalogowany. Jeśli nie, przekierowuje na stronę logowania.
     */
    protected function requireAuth(): void {
        if (!class_exists('Auth')) {
            die("Error: Auth class not found. Ensure autoloader is configured correctly.");
        }

        if (!Auth::isLoggedIn()) {
            header('Location: /user/login?status=login_required');
            exit;
        }
    }

    /**
     * Sprawdza, czy użytkownik ma wymaganą rolę. Jeśli nie, przekierowuje na stronę błędu (np. 403 Forbidden).
     * @param string $requiredRole Wymagana rola (np. 'admin', 'owner').
     */
    protected function requireRole(string $requiredRole): void {
        $this->requireAuth();

        $userRole = Auth::getRole();
        if ($userRole !== $requiredRole) {
            http_response_code(403);
            $this->renderView('errors/403');
            exit;
        }
    }
}