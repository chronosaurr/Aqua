<?php
/**
 * Model reprezentujący pojedynczy ticket (zadanie/zgłoszenie).
 */
class Ticket {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

}