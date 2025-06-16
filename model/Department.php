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
}