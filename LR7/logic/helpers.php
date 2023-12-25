<?php
function redirect(string $path): void {
    header("Location: $path");
    die();
}

class ValidationsErrors {
    private static array $errors = [];

    public static function add(string $message): void {
        self::$errors[] = $message;
    }

    public static function get(): array
    {
        return self::$errors;
    }
}