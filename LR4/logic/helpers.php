<?php
function redirect(string $path): void {
    header("Location: $path");
    die();
}

class RegistrationErrors {
    private static array $errors = [];

    public static function add(string $field_name, string $message): void {
        self::$errors[$field_name] = $message;
    }

    public static function get(): array
    {
        return self::$errors;
    }
}