<?php
function redirect(string $path): void {
    header("Location: $path");
    die();
}

// Сохранение значений из запроса
function save_value(string $key, mixed $value): void {
    $_SESSION['old'][$key] = $value;
}

// Получение значений из запроса
function get_old_value(string $key): mixed {
    $value = $_SESSION['old'][$key] ?? '';
    unset($_SESSION['old'][$key]);
    return $value;
}