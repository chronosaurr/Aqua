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

}