<?php

class Database {
    private static ?Database $instance = null;
    private PDO $connection;

    private static array $queryLog = [];
    private function __construct() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    /**
     * @return Database
     */
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO {
        return $this->connection;
    }

    /**
     * metoda do wykonywania zapytań, która mierzy ich czas.
     *
     * @param string $sql Zapytanie SQL.
     * @param array $params Parametry do bindowania.
     * @return PDOStatement Zwraca obiekt PDOStatement do dalszej obróbki (np. fetch).
     */
    public function query(string $sql, array $params = []): PDOStatement {
        $startTime = microtime(true);

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        $endTime = microtime(true);
        $duration = $endTime - $startTime;

        // zapisuje informacje o zapytaniu do naszego logu
        self::$queryLog[] = [
            'sql' => $sql,
            'duration' => $duration
        ];

        return $stmt;
    }

    /**
     * Zwraca liczbę wykonanych zapytań.
     */
    public static function getQueryCount(): int {
        return count(self::$queryLog);
    }

    /**
     * Zwraca łączny czas wykonania wszystkich zapytań.
     */
    public static function getTotalQueryTime(): float {
        $totalTime = 0;
        foreach (self::$queryLog as $log) {
            $totalTime += $log['duration'];
        }
        return $totalTime;
    }
}