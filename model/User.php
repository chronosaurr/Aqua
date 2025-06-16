<?php

class User {
    private PDO $db;
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * @return array|null Zwraca dane użytkownika lub null, jeśli nie znaleziono.
     */
    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * @return array|null Zwraca dane użytkownika lub null, jeśli nie znaleziono.
     */
    public function findByUsername(string $username): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * @param array $data Dane użytkownika (username, email, password).
     * @return bool Zwraca true w przypadku sukcesu, false w przypadku porażki.
     */
    public function create(array $data): bool {
        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            "INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)"
        );

        $stmt->bindParam(':username', $data['username'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(':password_hash', $password_hash, PDO::PARAM_STR);

        return $stmt->execute();
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