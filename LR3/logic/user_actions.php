<?php
require_once 'helpers.php';
require_once 'user_logic.php';
class UserActions
{
    public static function signUp(): void {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        if (!isset($_POST['signup'])) {
            return;
        }

        static::saveValuesSignUp();

        if (!static::validateSignOut()) {
            return;
        }

        try {
            UserLogic::signUp(
                $_POST['email'],
                $_POST['password'],
                $_POST['full_name'],
                $_POST['date_of_birth'],
                $_POST['address'],
                $_POST['sex'],
                $_POST['interests'],
                $_POST['vk'],
                $_POST['blood_type'],
                $_POST['rh_factor'],
            );
            $_SESSION['old'] = [];
            return;
        }
        catch (PDOException $e) {
            addValidationError('email', $e->getMessage());
        }
    }

    public static function signIn(): string {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return '';
        }

        if (!isset($_POST['signin'])) {
            return '';
        }

        saveValue('email', $_POST['email']);

        if (!static::validateSignIn()) {
            return '';
        }

        return UserLogic::signIn(
            $_POST['email'],
            $_POST['password'],
        );
    }

    public static function signOut(): void {
        UserLogic::signOut();
    }

    public static function getCurrentUser(): ?array {
        return UserLogic::getCurrentUser();
    }

    private static function saveValuesSignUp(): void {
        saveValue('email', $_POST['email']);
        saveValue('full_name', $_POST['full_name']);
        saveValue('date_of_birth', $_POST['date_of_birth']);
        saveValue('address', $_POST['address']);
        saveValue('sex', $_POST['sex']);
        saveValue('interests', $_POST['interests']);
        saveValue('vk', $_POST['vk']);
        saveValue('blood_type', $_POST['blood_type']);
        saveValue('rh_factor', $_POST['rh_factor']);
    }

    private static function validateSignOut(): bool {
        $_SESSION['validation_errors'] = [];

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            addValidationError('email', 'Неверный email');
        }

        if (empty($_POST['full_name'])) {
            addValidationError('full_name', 'Неверное ФИО');
        }

        if (!isValidDate($_POST['date_of_birth'])) {
            addValidationError('date_of_birth', 'Неверная дата рождения');
        }

        if (empty($_POST['address'])) {
            addValidationError('address', 'Пустой адрес');
        }

        if (!isValidSex($_POST['sex'])) {
            addValidationError('sex', 'Неверный пол');
        }

        if (empty($_POST['vk'])) {
            addValidationError('vk', 'Пустой вк');
        }

        if (!isValidBloodType($_POST['blood_type'])) {
            addValidationError('blood_type', 'Неверная группа крови');
        }

        if (!isValidRhFactor($_POST['rh_factor'])) {
            addValidationError('rh_factor', 'Неверный резус-фактор');
        }

        if (empty($_POST['password'])) {
            addValidationError('password', 'Пустой пароль');
        }
        elseif (!isValidPassword($_POST['password'])) {
            addValidationError('password', 'Неверный пароль');
        }

        if ($_POST['password'] !== $_POST['password_confirm']) {
            addValidationError('password_confirm', 'Пароли не совпадают');
        }

        if (!empty($_SESSION['validation_errors'])) {
            redirect('register.php');
            return false;
        }

        return true;
    }

    private static function validateSignIn(): bool {
        $_SESSION['validation_errors'] = [];

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            addValidationError('email', 'Неверный email');
        }

        if (empty($_POST['password'])) {
            addValidationError('password', 'Пустой пароль');
        }
        elseif (!isValidPassword($_POST['password'])) {
            addValidationError('password', 'Неверный пароль');
        }
        if (!empty($_SESSION['validation_errors'])) {
            redirect('login.php');
            return false;
        }

        return true;
    }

}