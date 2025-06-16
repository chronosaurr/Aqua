<?php
/**
 * Model reprezentujący pojedynczy załącznik do ticketu.
 */
class Attachment {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

}