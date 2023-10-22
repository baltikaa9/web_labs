<?php
require_once 'validator.php';
require_once 'user_logic.php';
require_once 'helpers.php';
class UserActions
{
    public static function sign_up(): void {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return;
        }

        if (!isset($_POST['signup'])) {
            return;
        }

        static::save_sign_up_values();

        $user_exists = UserLogic::is_user_exists($_POST['email']);
        if ($user_exists) {
            add_registration_error('email', 'Пользователь с таким email уже существует');
        }
        $success_validation = Validator::sign_up_validate();

        if (!$user_exists && $success_validation) {
            UserLogic::sign_up(
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
//            unset($_POST['old']);
//            delete_registration_errors();
            redirect('auth.php');
        }
    }

    public static function sign_in(): string {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return '';
        }

        if (!isset($_POST['signin'])) {
            return '';
        }

        save_value('email', $_POST['email']);

        if (!Validator::sign_in_validate()) {
            return '';
        }

        $message = UserLogic::sign_in(
            $_POST['email'],
            $_POST['password'],
        );
        if (!$message) {
            unset($_SESSION['old']);
            redirect('index.php');
        }
        return $message;
    }

    public static function sign_out(): void {
        UserLogic::sign_out();
    }

    public static function get_current_user(): ?array {
        return UserLogic::get_current_user();
    }

    private static function save_sign_up_values(): void {
        save_value('email', $_POST['email']);
        save_value('full_name', $_POST['full_name']);
        save_value('date_of_birth', $_POST['date_of_birth']);
        save_value('address', $_POST['address']);
        save_value('sex', $_POST['sex']);
        save_value('interests', $_POST['interests']);
        save_value('vk', $_POST['vk']);
        save_value('blood_type', $_POST['blood_type']);
        save_value('rh_factor', $_POST['rh_factor']);
    }
}
