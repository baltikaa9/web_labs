<?php
require_once 'helpers.php';

class Validator {
    private static array $errors;
    public static function sign_up_validate(): bool {
        self::$errors = [];

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
            RegistrationErrors::add(
                'password',
                'Пароль должен быть длиннее 6 символов, содержать большие латинские буквы, 
                маленькие латинские буквы, спецсимволы (знаки препинания, арифметические действия и тп), пробел, дефис, 
                подчеркивание и цифры.'
            );
        }

        if ($_POST['password'] !== $_POST['password_confirm']) {
            static::add_validation_error('password_confirm', 'Пароли не совпадают');
        }

        if (!empty(self::$errors)) {
            return false;
        }

        return true;
    }

    public static function sign_in_validate(): bool {
        self::$errors = [];

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            static::add_validation_error('email', 'Неверный email');
        }

        if (!empty(self::$errors)) {
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
//      What does ?= mean "(?=.*\d)"
//      ?= — это положительный просмотр вперед, тип утверждения нулевой ширины.
//      Он говорит о том, что за захваченным совпадением должно следовать все, что находится в круглых скобках,
//      но эта часть не фиксируется. Ваш пример означает, что за совпадением должно следовать ноль или более символов,
//      а затем цифра (но, опять же, эта часть не фиксируется).
        return preg_match(
            '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.{7,})(?=.*[!@#$%^&*()+=\[\]{};\':"|,.<>?])(?=.* +)(?=.*-+)(?=.*_)[^А-Яа-я]*$/',
            $password,
        );
    }

    private static function add_validation_error(string $field_name, string $message): void {
        self::$errors[$field_name] = $message;
    }

    public static function get_validation_error(string $field_name): string {
        return self::$errors[$field_name] ?? '';
    }
}
