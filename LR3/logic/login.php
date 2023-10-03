<?php

session_start();

require_once 'helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    saveValue('email', $email);

    // validation
    $_SESSION['validation_errors'] = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        addValidationError('email', 'Неверный email');
    }

    if (empty($password)) {
        addValidationError('password', 'Пустой пароль');
    }
    elseif (!isValidPassword($password)) {
        addValidationError('password', 'Неверный пароль');
    }

    if (!empty($_SESSION['validation_errors'])) {
        redirect('login.php');
    }

    $pdo = getPDO();

    $query = "SELECT full_name, password FROM users WHERE email = :email";
    $params = [
        'email' => $email,
    ];
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $user = $stmt->fetch();
    if (password_verify($password, $user['password'])) {
        echo 'Пароль правильный!';
    }
    else {
        echo 'Пароль неправильный.';
    }

    $_SESSION['old'] = [];
}
