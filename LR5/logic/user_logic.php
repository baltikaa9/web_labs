<?php
require_once 'user_table.php';
require_once 'block_user_table.php';

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
        $user_ip = $_SERVER['REMOTE_ADDR'];

        $block_user_message = static::is_block_user($user_ip);
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
            return static::block_user($user_ip);
        }

        $_SESSION['USER_ID'] = $user['id'];
        return '';
    }

    private static function block_user(string $ip): string {
        $block_user = BlockUser::get($ip);
        if (!$block_user) {
            $datetime = (new DateTime('now'))->add(new DateInterval("PT1H"));
            $block_user = BlockUser::create($ip, $datetime->format('Y-m-d H:i:s'));
        }
        else {
            $block_user = BlockUser::update_count($ip, $block_user['count'] + 1);
        }
        return 'Неверный пароль. У вас осталось ' . 3 - $block_user['count'] . ' попыток';
    }

    private static function is_block_user(string $ip): string {
        $cur_datetime = new DateTime('now');
        $block_user = BlockUser::get($ip);
        if ($block_user &&
            $block_user['count'] === 3 &&
            $cur_datetime < new DateTime($block_user['block_expire'])
        ) {
            $datetime_diff = (new DateTime($block_user['block_expire']))->diff($cur_datetime);
            return 'Вы ввели неверный пароль 3 раза и сможете авторизоваться только через ' .
                $datetime_diff->format('%H:%i:%s');
        }
        elseif ($block_user &&
            $cur_datetime >= new DateTime($block_user['block_expire'])
        ) {
            BlockUser::delete($ip);
        }
        return '';
    }

    public static function is_user_exists(string $email): bool {
        $user = UserTable::get_by_email($email);
        return (bool) $user;
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