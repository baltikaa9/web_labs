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
    $value = $_POST['old'][$key] ?? '';
    unset($_POST['old'][$key]);
    return $value;
}

function add_registration_error(string $field_name, string $message): void {
    if (!isset($_SESSION['registration_errors'])) $_SESSION['registration_errors'] = [];
    $_SESSION['registration_errors'][$field_name] = $message;
}

function get_registration_errors(): ?array {
//    if (isset($_SESSION['registration_errors'])) return $_SESSION['registration_errors'];
    return $_SESSION['registration_errors'] ?? null;
}

function delete_registration_errors(): void {
    if (isset($_SESSION['registration_errors'])) unset($_SESSION['registration_errors']);
}