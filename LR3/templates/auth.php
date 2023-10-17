<?php
session_start();
require_once '../logic/user_actions.php';
$message = UserActions::sign_in();
$current_user = UserActions::get_current_user();
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
        <?= $message ? '<h3 class="text-center">' . $message . '</h3>' : '' ?>
        <?php if ($current_user):?>
            <?='<h1 class="text-center">Вы уже авторизованы</h1>'?>
        <?php else:?>
            <form action="auth.php" method="post" class="form-register col-5 mx-auto">
            <div class="form-group">
                <label for="email">
                    <p>Email</p>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        placeholder="example@example.com"
                        value="<?= htmlspecialchars(get_old_value('email')) ?>"
                        required
                    >
                    <small> <?= Validator::validation_error_message('email') ?> </small>
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
                        required
                    >
                    <small> <?= Validator::validation_error_message('password') ?> </small>
                </label>
            </div>
            <div class="d-flex justify-content-center mb-2">
                <button type="submit" name="signin" class="btn btn-dark">Войти</button>
            </div>
            <div class="form-group">
                <p class="text-center">Ещё нет аккаунта? <a href="registration.php">Зарегистрируйтесь</a></p>
            </div>
        </form>
        <?php endif?>
    </div>
</main>
<?php
unset($_SESSION['validation_errors']);
?>
</body>