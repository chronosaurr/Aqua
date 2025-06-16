<?php

class User {
    private Database $db;
    public function __construct(Database $db) {
        $this->db = $db;
    }

    /**
     * @return array|null Zwraca dane użytkownika lub null, jeśli nie znaleziono.
     */
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->query("SELECT * FROM users WHERE email = :email", ['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    /**
     * @return array|null Zwraca dane użytkownika lub null, jeśli nie znaleziono.
     */
    public function findByUsername(string $username): ?array {
        $stmt = $this->db->query("SELECT * FROM users WHERE username = :username", ['username' => $username]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    /**
     * @param array $data Dane użytkownika (username, email, password).
     * @return bool Zwraca true w przypadku sukcesu, false w przypadku porażki.
     */
    public function create(array $data): bool {
        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

        $params = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password_hash' => $password_hash
        ];
        // Metoda query() zwraca PDOStatement, którego wsm tu nie potrzebujemy,
        // tho zapytanie się wykona i zostanie zalogowane.
        $this->db->query("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)", $params);
        return true;
    }

    /**
     * weryfikacja danych logowania użytkownika.
     * @param string $email
     * @param string $password
     * @return array|null Zwraca dane użytkownika w przypadku sukcesu, null w przypadku porażki.
     */
    public function login(string $email, string $password): ?array {
        $user = $this->findByEmail($email);

        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }
        return null;
    }
}