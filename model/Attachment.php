<?php

class Attachment {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    /**
     * Zapisuje informacje o załączniku w bazie danych.
     * @param int $ticketId ID ticketu, do którego należy załącznik.
     * @param array $fileData Dane pliku (original_filename, stored_filename, filesize).
     * @return bool
     */
    public function create(int $ticketId, array $fileData): bool {
        $sql = "INSERT INTO attachments (ticket_id, original_filename, stored_filename, filesize)
                VALUES (:ticket_id, :original_filename, :stored_filename, :filesize)";

        $params = [
            'ticket_id' => $ticketId,
            'original_filename' => $fileData['original_filename'],
            'stored_filename' => $fileData['stored_filename'],
            'filesize' => $fileData['filesize']
        ];

        $this->db->query($sql, $params);
        return true;
    }

    /**
     * Znajduje załącznik po jego ID.
     * @param int $id ID załącznika.
     * @return array|null
     */
    public function findById(int $id): ?array {
        $stmt = $this->db->query("SELECT * FROM attachments WHERE id = :id", ['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Znajduje wszystkie załączniki dla danego ticketu.
     * @param int $ticketId ID ticketu.
     * @return array
     */
    public function findByTicketId(int $ticketId): array {
        $stmt = $this->db->query("SELECT * FROM attachments WHERE ticket_id = :ticket_id", ['ticket_id' => $ticketId]);
        return $stmt->fetchAll();
    }

    /**
     * Usuwa załącznik z bazy danych.
     * @param int $id ID załącznika do usunięcia.
     * @return bool
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM attachments WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
        return true;
    }
}
