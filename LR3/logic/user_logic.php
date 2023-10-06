<?php
require_once 'user_table.php';

class UserLogic
{
    public static function signUp(
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
        try{
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
        catch (PDOException) {
            throw new PDOException('Email уже зарегистрирован');
        }
    }

    public static function signIn(string $email, string $password): string {
        if (static::isAuthorized()) {
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

    public static function signOut(): void {
        unset($_SESSION['USER_ID']);
    }

    public static function isAuthorized(): bool {
//        return (int)$_SESSION['USER_ID'] > 0;
        return isset($_SESSION['USER_ID']);
    }

    public static function getCurrentUser(): ?array {
        if (!self::isAuthorized()) {
            return null;
        }

        return UserTable::get_by_id($_SESSION['USER_ID']);
    }
}