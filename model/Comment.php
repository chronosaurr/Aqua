<?php
/**
 * Model reprezentujący pojedynczy komentarz do ticketu.
 */
class Comment {
    private Database $db;
    public function __construct(Database $db) {
        $this->db = $db;
    }

}