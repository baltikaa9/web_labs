<?php
function redirect(string $path): void {
    header("Location: $path");
    die();
}

function add_registration_error(string $field_name, string $message): void {
    $_POST['registration_errors'][$field_name] = $message;
}

function get_registration_errors(): ?array {
    return $_POST['registration_errors'] ?? null;
}