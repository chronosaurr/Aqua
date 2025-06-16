<?php

/**
 * Model reprezentujący pojedynczy dział w systemie.
 */
class Department {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }
    /**
     * Pobiera wszystkie departamenty z bazy danych.
     * @return array Tablica z departamentami.
     */
    public function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM departments ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    /**
     * Tworzy nowy dział w bazie danych.
     * @param string $name Nazwa nowego działu.
     * @return bool Zwraca true w przypadku sukcesu.
     */
    public function create(string $name): bool {
        $this->db->query("INSERT INTO departments (name) VALUES (:name)", ['name' => $name]);
        return true;
    }
    /**
     * Znajduje dział po jego ID.
     * @param int $id ID działu do znalezienia.
     * @return array|null Zwraca tablicę z danymi działu lub null, jeśli nie znaleziono.
     */
    public function findById(int $id): ?array {
        $stmt = $this->db->query("SELECT * FROM departments WHERE id = :id", ['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Aktualizuje nazwę istniejącego działu.
     * @param int $id ID działu do aktualizacji.
     * @param string $name Nowa nazwa dla działu.
     * @return bool
     */
    public function update(int $id, string $name): bool {
        $this->db->query(
            "UPDATE departments SET name = :name WHERE id = :id",
            ['id' => $id, 'name' => $name]
        );
        return true;
    }
}