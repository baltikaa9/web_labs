<?php
require_once 'config.php';

class DB {
    private PDO $pdo;
    private static DB | null $instance = null;
    public function __construct() {
        try {
            $this->pdo = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER);
        }
        catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

//    Создает экземпляр класса, хранящий подключение к БД
    public static function getInstance(): DB {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

//    Экземпляр подключения к БД
    public static function connection(): PDO {
        return static::getInstance()->pdo;
    }

    public static function prepare(string $statement): PDOStatement {
        return static::connection()->prepare($statement);
    }
}
