<?php
function redirect(string $path): void {
    header("Location: $path");
    die();
}

// Сохранение значений из запроса
function save_value(string $key, mixed $value): void {
    $_POST['old'][$key] = $value;
}

// Получение значений из запроса
function get_old_value(string $key): mixed {
    return $_POST['old'][$key] ?? '';
}

function add_registration_error(string $field_name, string $message): void {
    $_POST['registration_errors'][$field_name] = $message;
}

function get_registration_errors(): ?array {
    return $_POST['registration_errors'] ?? null;
}