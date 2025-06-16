<?php
class Auth {
    /**
     * @param int $id ID użytkownika z bazy danych.
     * @param string $username Nazwa użytkownika.
     * @param string $role Rola użytkownika.
     */
    public static function login(int $id, string $username, string $role): void {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $_SESSION['logged_in'] = true;
    }

    /**
     * Niszczy sesję i wylogowuje użytkownika.
     */
    public static function logout(): void {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    /**
     * Sprawdza, czy użytkownik jest aktualnie zalogowany.
     * @return bool
     */
    public static function isLoggedIn(): bool {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Zwraca ID zalogowanego użytkownika.
     * @return int|null
     */
    public static function getUserId(): ?int {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Zwraca nazwę zalogowanego użytkownika.
     * @return string|null
     */
    public static function getUsername(): ?string {
        return $_SESSION['username'] ?? null;
    }

    /**
     * Zwraca rolę zalogowanego użytkownika.
     * @return string|null
     */
    public static function getRole(): ?string {
        return $_SESSION['role'] ?? null;
    }
}
