<?php

class Ticket {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    /**
     * Tworzy nowy ticket w bazie danych.
     * @param array $data Dane ticketu.
     * @return int ID nowo utworzonego ticketu.
     */
    public function create(array $data): int {
        $sql = "INSERT INTO tickets (title, description, priority, department_id, assignee_id, deadline_at, creator_id)
                VALUES (:title, :description, :priority, :department_id, :assignee_id, :deadline_at, :creator_id)";

        $params = [
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => $data['priority'],
            'department_id' => $data['department_id'],
            'assignee_id' => $data['assignee_id'],
            'deadline_at' => $data['deadline_at'],
            'creator_id' => $data['creator_id']
        ];

        $this->db->query($sql, $params);
        return (int)$this->db->getConnection()->lastInsertId();
    }

    /**
     * Aktualizuje istniejący ticket.
     * @param int $id ID ticketu do aktualizacji.
     * @param array $data Nowe dane ticketu.
     * @return bool
     */
    public function update(int $id, array $data): bool {
        $sql = "UPDATE tickets SET 
                    title = :title, 
                    description = :description, 
                    status = :status,
                    priority = :priority, 
                    department_id = :department_id, 
                    assignee_id = :assignee_id, 
                    deadline_at = :deadline_at,
                    updated_at = NOW()
                WHERE id = :id";

        $params = [
            'id' => $id,
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'priority' => $data['priority'],
            'department_id' => $data['department_id'],
            'assignee_id' => $data['assignee_id'],
            'deadline_at' => $data['deadline_at']
        ];

        $this->db->query($sql, $params);
        return true;
    }

    /**
     * Usuwa ticket z bazy danych.
     * @param int $id ID ticketu do usunięcia.
     * @return bool
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM tickets WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
        return true;
    }

    /**
     * Znajduje ticket po jego ID.
     * @param int $id ID ticketu.
     * @return array|null
     */
    public function findById(int $id): ?array {
        $stmt = $this->db->query("SELECT * FROM tickets WHERE id = :id", ['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Pobiera wszystkie tickety.
     * @return array
     */
    public function findAll(): array {
        $sql = "SELECT t.*, d.name as department_name, u.username as creator_username, a.username as assignee_username
                FROM tickets t
                LEFT JOIN departments d ON t.department_id = d.id
                LEFT JOIN users u ON t.creator_id = u.id
                LEFT JOIN users a ON t.assignee_id = a.id
                ORDER BY t.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}