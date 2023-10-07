<?php
require_once 'helpers.php';

class Validator {
    public static function sign_up_validate(): bool {
        $_SESSION['validation_errors'] = [];

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            static::add_validation_error('email', 'Неверный email');
        }

        if (empty($_POST['full_name'])) {
            static::add_validation_error('full_name', 'Неверное ФИО');
        }

        if (!static::validate_date($_POST['date_of_birth'])) {
            static::add_validation_error('date_of_birth', 'Неверная дата рождения');
        }

        if (empty($_POST['address'])) {
            static::add_validation_error('address', 'Пустой адрес');
        }

        if (!static::validate_sex($_POST['sex'])) {
            static::add_validation_error('sex', 'Неверный пол');
        }

        if (!filter_var($_POST['vk'], FILTER_VALIDATE_URL)) {
            static::add_validation_error('vk', 'Неверный вк');
        }

        if (!static::validate_blood_type($_POST['blood_type'])) {
            static::add_validation_error('blood_type', 'Неверная группа крови');
        }

        if (!static::validate_rh_factor($_POST['rh_factor'])) {
            static::add_validation_error('rh_factor', 'Неверный резус-фактор');
        }

        if (empty($_POST['password'])) {
            static::add_validation_error('password', 'Пустой пароль');
        }
        elseif (!static::validate_password($_POST['password'])) {
            static::add_validation_error('password', 'Неверный пароль');
            $_SESSION['registration_error'] = 'Пароль должен содержать от 7 символов';
        }

        if ($_POST['password'] !== $_POST['password_confirm']) {
            static::add_validation_error('password_confirm', 'Пароли не совпадают');
        }

        if (!empty($_SESSION['validation_errors'])) {
            redirect('registration.php');
            return false;
        }

        return true;
    }

    public static function sign_in_validate(): bool {
        $_SESSION['validation_errors'] = [];

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            static::add_validation_error('email', 'Неверный email');
        }
        
        if (!empty($_SESSION['validation_errors'])) {
            redirect('auth.php');
            return false;
        }

        return true;
    }

    private static function validate_date(string $date): bool {
        return (strtotime($date) !== false);
    }

    private static function validate_sex(string | null $sex): bool {
        return $sex === 'male' || $sex === 'female';
    }

    private static function validate_blood_type(string | null $blood_type): bool {
        return $blood_type === '1' || $blood_type === '2' || $blood_type === '3' || $blood_type === '4';
    }

    private static function validate_rh_factor(string | null $rh_factor): bool {
        return $rh_factor === 'plus' || $rh_factor === 'minus';
    }

    private static function validate_password(string $password): bool {
        if (strlen($password) <= 6) { return false; }
        return true;
    }

    private static function add_validation_error(string $fieldName, string $message): void {
        $_SESSION['validation_errors'][$fieldName] = $message;
    }

    public static function validation_error_message(string $fieldName): string {
//    return isset($_SESSION['validation'][$field]) ? $_SESSION['validation'][$field] : '';
        $message = $_SESSION['validation_errors'][$fieldName] ?? '';
        unset($_SESSION['validation_errors'][$fieldName]);
        return $message;
    }
}
