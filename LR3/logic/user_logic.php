<?php
require_once 'user_table.php';

class UserLogic
{
    public static function sign_up(
        string $email,
        string $password,
        string $full_name,
        string $date_of_birth,
        string $address,
        string $sex,
        string $interests,
        string $vk,
        string $blood_type,
        string $rh_factor,
    ): void {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $user = UserTable::get_by_email($email);
        if ($user) {
            throw new PDOException('Пользователь с таким email уже существует');
        }
        UserTable::create(
            $email,
            $hashed_password,
            $full_name,
            $date_of_birth,
            $address,
            $sex,
            $interests,
            $vk,
            $blood_type,
            $rh_factor,
        );
    }

    public static function sign_in(string $email, string $password): string {
        if (static::is_authorized()) {
            return 'Вы уже авторизованы';
        }

        $user = UserTable::get_by_email($email);
        if ($user === null) {
            return 'Пользователь с таким email не найден';
        }

        if (!password_verify($password, $user['password'])) {
            return 'Неверный пароль';
        }

        $_SESSION['USER_ID'] = $user['id'];
        return '';
    }

    public static function sign_out(): void {
        unset($_SESSION['USER_ID']);
    }

    public static function is_authorized(): bool {
//        return (int)$_SESSION['USER_ID'] > 0;
        return isset($_SESSION['USER_ID']);
    }

    public static function get_current_user(): ?array {
        if (!self::is_authorized()) {
            return null;
        }

        return UserTable::get_by_id($_SESSION['USER_ID']);
    }
}