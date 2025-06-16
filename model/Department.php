<?php

/**
 * Model reprezentujący pojedynczy dział w systemie.
 */
class Department {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

}