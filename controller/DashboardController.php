<?php

require_once CONTROLLER_PATH . '/BaseController.php';

class DashboardController extends BaseController {
    public function index(): void {
        $data = [
            'title' => 'Panel Główny',
            'activeController' => 'dashboard' // info dla aktywnego menu
        ];
        $this->renderView('dashboard/index', $data);
    }
}
