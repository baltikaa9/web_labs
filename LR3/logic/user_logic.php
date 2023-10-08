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
        $cur_datetime = new DateTime('now');

        $block_user_message = static::is_block_user($cur_datetime);
        if ($block_user_message) {
            return $block_user_message;
        }

        if (static::is_authorized()) {
            return 'Вы уже авторизованы';
        }

        $user = UserTable::get_by_email($email);
        if ($user === null) {
            return 'Пользователь с таким email не найден';
        }

        if (!password_verify($password, $user['password'])) {
            if (!isset($_SESSION['block_user'])) {
                $datetime = $cur_datetime->add(new DateInterval("PT1H"));
                $_SESSION['block_user'] = ['count' => 1, 'expire' => $datetime];
            }
            else {
                $_SESSION['block_user']['count']++;
            }
            return 'Неверный пароль. У вас осталось ' . 3 - $_SESSION['block_user']['count'] + 1 . ' попыток';
        }

        $_SESSION['USER_ID'] = $user['id'];
        return '';
    }

    private static function is_block_user($cur_datetime): string {
        if (isset($_SESSION['block_user']) &&
            $_SESSION['block_user']['count'] === 3 &&
            $cur_datetime < $_SESSION['block_user']['expire']
        ) {
            $datetime_diff = $_SESSION['block_user']['expire']->diff($cur_datetime);
            return 'Вы ввели неверный пароль 3 раза и сможете авторизоваться только через ' .
                $datetime_diff->format('%H:%i:%s');
        }
        elseif (isset($_SESSION['block_user']) &&
            $cur_datetime >= $_SESSION['block_user']['expire']
        ) {
            unset($_SESSION['block_user']);
        }
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