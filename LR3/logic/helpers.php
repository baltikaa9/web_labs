<?php
function redirect(string $path): void {
    header("Location: $path");
    die();
}

function validationErrorMessage(string $fieldName): string {
//    return isset($_SESSION['validation'][$field]) ? $_SESSION['validation'][$field] : '';
    $message = $_SESSION['validation_errors'][$fieldName] ?? '';
    unset($_SESSION['validation_errors'][$fieldName]);
    return $message;
}

function addValidationError(string $fieldName, string $message): void {
    $_SESSION['validation_errors'][$fieldName] = $message;
}

function isValidDate(string $date): bool {
    return (strtotime($date) !== false);
}

function isValidSex(string | NULL $sex): bool {
//    print_r($sex === 'male' || $sex === 'female');
    return $sex === 'male' || $sex === 'female';
}

function isValidBloodType(string | NULL $blood_type): bool {
    return $blood_type === '1' || $blood_type === '2' || $blood_type === '3' || $blood_type === '4';
}

function isValidRhFactor(string | NULL $rh_factor): bool {
    return $rh_factor === 'plus' || $rh_factor === 'minus';
}

function isValidPassword(string $password): bool {
    if (strlen($password) <= 6) { return false; }
    return true;
}

function saveValue(string $key, mixed $value): void {
    $_SESSION['old'][$key] = $value;
}

function getOldValue(string $key): mixed {
    $value = $_SESSION['old'][$key] ?? '';
    unset($_SESSION['old'][$key]);
    return $value;
}