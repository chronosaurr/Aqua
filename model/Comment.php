<?php
// model/Comment.php

/**
 * Model reprezentujący pojedynczy komentarz do ticketu.
 */
class Comment {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }
    
    /**
     * Pobiera wszystkie komentarze dla danego ticketu.
     * Komentarze są posortowane chronologicznie.
     * @param int $ticketId ID ticketu.
     * @return array Tablica z komentarzami.
     */
    public function findByTicketId(int $ticketId): array {
        // Zakładamy, że tabela `comments` ma kolumny `id`, `ticket_id`, `user_id`, `content`, `created_at`
        // Wyświetlić nazwę użytkownika, który dodał komentarz.
        // Kolumna `user_id` w tabeli `comments` jest kluczem obcym do tabeli `users`.
        $sql = "SELECT c.*, u.username as user_username
                FROM comments c
                JOIN users u ON c.user_id = u.id
                WHERE c.ticket_id = :ticket_id
                ORDER BY c.created_at ASC"; // Sort chronologicznie

        $stmt = $this->db->query($sql, ['ticket_id' => $ticketId]);
        return $stmt->fetchAll();
    }

    /**
     * Tworzy nowy komentarz w bazie danych.
     * @param int $ticketId ID ticketu, do którego dodawany jest komentarz.
     * @param int $userId ID użytkownika, który dodaje komentarz.
     * @param string $content Treść komentarza.
     * @return bool Zwraca true w przypadku sukcesu.
     */
    public function create(int $ticketId, int $userId, string $content): bool {
        $sql = "INSERT INTO comments (ticket_id, user_id, content, created_at)
                VALUES (:ticket_id, :user_id, :content, NOW())";
        
        $params = [
            'ticket_id' => $ticketId,
            'user_id' => $userId,
            'content' => $content
        ];

        $this->db->query($sql, $params);
        return true;
    }
}
