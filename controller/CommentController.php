<?php
// controller/CommentController.php

class CommentController extends BaseController {

    public function __construct() {
        // Wszystkie akcje związane z komentarzami wymagają zalogowania
        $this->requireAuth();
    }

    /**
     * Zapisuje nowy komentarz w bazie danych.
     */
    public function store(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            // Jeśli ktoś próbuje wejść na ten URL bezpośrednio, przekieruj go
            header('Location: /');
            exit;
        }

        $content = trim($_POST['content'] ?? '');
        $ticketId = (int)($_POST['ticket_id'] ?? 0);
        $userId = Auth::getUserId(); // Pobieramy ID zalogowanego użytkownika

        // Prosta walidacja
        if (empty($content) || $ticketId <= 0) {
            // W razie błędu, przekieruj z powrotem do ticketu z komunikatem
            header('Location: /ticket/show/' . $ticketId . '?error=comment_empty');
            exit;
        }

        // Używamy "leniwego ładowania" modelu
        $commentModel = $this->loadModel('Comment');
        $commentModel->create($ticketId, $userId, $content);

        // Po pomyślnym dodaniu komentarza, przekieruj z powrotem na stronę ticketu
        header('Location: /ticket/show/' . $ticketId . '#comments'); // #comments przeniesie widok do sekcji komentarzy
        exit;
    }
}
