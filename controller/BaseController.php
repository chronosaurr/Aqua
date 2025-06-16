<?php

abstract class BaseController {
    /**
     * @param string $viewName Nazwa widoku do wczytania (np. 'dashboard/index')
     * @param array $data Dane do przekazania do widoku (stają się zmiennymi)
     */
    protected function renderView(string $viewName, array $data = []): void {
        extract($data);

        require_once VIEW_PATH . '/partials/header.php';
        require_once VIEW_PATH . '/' . $viewName . '.php';
        require_once VIEW_PATH . '/partials/footer.php';
    }
}
