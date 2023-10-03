<?php

session_start();

require_once 'helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Выносим данные из POST
    $email = $_POST['email'] ?? null;
    $full_name = $_POST['full_name'] ?? null;
    $date_of_birth = $_POST['date_of_birth'] ?? null;
    $address = $_POST['address'] ?? null;
    $sex = $_POST['sex'] ?? null;
    $interests = $_POST['interests'] ?? null;
    $vk = $_POST['vk'] ?? null;
    $blood_type = $_POST['blood_type'] ?? null;
    $rh_factor = $_POST['rh_factor'] ?? null;
    $password = $_POST['password'] ?? null;
    $password_confirm = $_POST['password_confirm'] ?? null;


    saveValue('email', $email);
    saveValue('full_name', $full_name);
    saveValue('date_of_birth', $date_of_birth);
    saveValue('address', $address);
    saveValue('sex', $sex);
    saveValue('interests', $interests);
    saveValue('vk', $vk);
    saveValue('blood_type', $blood_type);
    saveValue('rh_factor', $rh_factor);


    // validation
    $_SESSION['validation_errors'] = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        addValidationError('email', 'Неверный email');
    }

    if (empty($full_name)) {
        addValidationError('full_name', 'Неверное ФИО');
    }

    if (!isValidDate($date_of_birth)) {
        addValidationError('date_of_birth', 'Неверная дата рождения');
    }

    if (empty($address)) {
        addValidationError('address', 'Пустой адрес');
    }

    if (!isValidSex($sex)) {
        addValidationError('sex', 'Неверный пол');
    }

    if (empty($vk)) {
        addValidationError('vk', 'Пустой вк');
    }

    if (!isValidBloodType($blood_type)) {
        addValidationError('blood_type', 'Неверная группа крови');
    }

    if (!isValidRhFactor($rh_factor)) {
        addValidationError('rh_factor', 'Неверный резус-фактор');
    }

    if (empty($password)) {
        addValidationError('password', 'Пустой пароль');
    }
    elseif (!isValidPassword($password)) {
        addValidationError('password', 'Неверный пароль');
    }

    if ($password !== $password_confirm) {
        addValidationError('password_confirm', 'Пароли не совпадают');
    }

    if (!empty($_SESSION['validation_errors'])) {
        redirect('register.php');
    }

    $pdo = getPDO();

    $query = "INSERT INTO users (email, password, full_name, date_of_birth, address, sex, interests, vk, blood_type, rh_factor) 
                VALUES (:email, :password, :full_name, :date_of_birth, :address, :sex, :interests, :vk, :blood_type, :rh_factor)";
    $params = [
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'full_name' => $full_name,
        'date_of_birth' => $date_of_birth,
        'address' => $address,
        'sex' => $sex,
        'interests' => $interests,
        'vk' => $vk,
        'blood_type' => $blood_type,
        'rh_factor' => $rh_factor,
    ];

    $stmt = $pdo->prepare($query);
    try {
        $stmt->execute($params);
    }
    catch (PDOException $exception) {
        addValidationError('email', 'Email уже зарегистрирован');
    }

    $_SESSION['old'] = [];
}
