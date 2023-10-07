<?php
session_start();
//print_r($_SESSION['validation_errors']);
//print_r($_SESSION['old']);
require_once '../logic/user_actions.php';
$message = UserActions::sign_in();
//print_r(UserActions::getCurrentUser());
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once 'head.php'?>
<body>
<?php require_once 'header.php'?>
<main class="content">
    <div class="container">
        <p class="py-2">
            <a href="/web_labs/LR3">Домашняя страница</a>
            > Вход в аккаунт
        </p>
        <?= $message ? '<h3>' . $message . '</h3>' : '' ?>
        <form action="login.php" method="post" class="form-register col-5 mx-auto">
            <div class="form-group">
                <label for="email">
                    <p>Email</p>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        placeholder="example@example.com"
                        value="<?= getOldValue('email') ?>"
                    >
                    <small> <?= validationErrorMessage('email') ?> </small>
                </label>
            </div>
            <div class="form-group">
                <label for="password">
                    <p>Пароль</p>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="**********"
                    >
                    <small> <?= validationErrorMessage('password') ?> </small>
                </label>
            </div>
            <div class="d-flex justify-content-center mb-2">
                <button type="submit" name="signin" class="btn btn-dark">Войти</button>
            </div>
            <div class="form-group">
                <p class="text-center">Ещё нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
            </div>
        </form>
    </div>
</main>
<?php
$_SESSION['validation_errors'] = [];
?>
</body>