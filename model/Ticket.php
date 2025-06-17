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
    public function create(array $data): int|false {
        $sql = "INSERT INTO tickets (title, description, priority, creator_id, assignee_id, department_id, deadline_at) 
                VALUES (:title, :description, :priority, :creator_id, :assignee_id, :department_id, :deadline_at)";
        
        $params = [
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => $data['priority'],
            'creator_id' => $data['creator_id'],
            'assignee_id' => $data['assignee_id'],
            'department_id' => $data['department_id'],
            'deadline_at' => $data['deadline_at']
        ];
        
        $this->db->query($sql, $params);
        return (int)$this->db->getConnection()->lastInsertId();
    }

    /**
     * Aktualizuje istniejący ticket w bazie danych.
     * @param int $id ID ticketu do aktualizacji.
     * @param array $data Dane do aktualizacji.
     * @return bool
     */
    public function update(int $id, array $data): bool {
        // Dodajemy logikę automatycznego ustawiania `closed_at`
        $closed_at_sql = "";
        if ($data['status'] === 'zamknięty' && empty($data['closed_at'])) {
            $data['closed_at'] = date('Y-m-d H:i:s');
            $closed_at_sql = ", closed_at = :closed_at";
        }

        $sql = "UPDATE tickets SET 
                    title = :title, 
                    description = :description,
                    status = :status,
                    priority = :priority,
                    department_id = :department_id,
                    assignee_id = :assignee_id,
                    deadline_at = :deadline_at
                    {$closed_at_sql}
                WHERE id = :id";
        
        // Łączymy parametry
        $params = array_merge($data, ['id' => $id]);
        
        $this->db->query($sql, $params);
        return true;
    }

    /**
     * Usuwa ticket z bazy danych.
     * @param int $id ID ticketu do usunięcia.
     * @return bool
     */
    public function delete(int $id): bool {
        $this->db->query("DELETE FROM tickets WHERE id = :id", ['id' => $id]);
        return true;
    }

    public function findById(int $id): ?array {
        // Ta metoda powinna łączyć tabele, aby pobrać nazwy zamiast samych ID
        $sql = "SELECT t.*, 
                       u_creator.username AS creator_username, 
                       u_assignee.username AS assignee_username,
                       d.name AS department_name
                FROM tickets t
                JOIN users u_creator ON t.creator_id = u_creator.id
                LEFT JOIN users u_assignee ON t.assignee_id = u_assignee.id
                JOIN departments d ON t.department_id = d.id
                WHERE t.id = :id";
        
        $stmt = $this->db->query($sql, ['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Pobiera wszystkie tickety.
     * @return array
     */
    public function findAll(): array {
        // Ta metoda również powinna łączyć tabele dla czytelności na liście
        $sql = "SELECT t.id, t.title, t.status, t.priority, d.name as department_name, u_assignee.username as assignee_username
                FROM tickets t
                JOIN departments d ON t.department_id = d.id
                LEFT JOIN users u_assignee ON t.assignee_id = u_assignee.id
                ORDER BY t.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }


}