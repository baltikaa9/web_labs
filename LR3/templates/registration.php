<?php
session_start();
require_once '../logic/user_actions.php';
UserActions::sign_up();
$current_user = UserActions::get_current_user();
$registration_errors = get_registration_errors();
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
            > Создание аккаунта
        </p>
        <?php if ($current_user):?>
            <?='<h1 class="text-center">Вы уже авторизованы</h1>'?>
        <?php else:?>
            <form action="registration.php" method="post" class="form-register col-5 mx-auto">
            <div class="form-group">
                <label for="email">
                    <p>Email (Логин)</p>
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
                <label for="full_name">
                    <p>ФИО</p>
                    <input
                        type="text"
                        name="full_name"
                        id="full_name"
                        class="form-control"
                        placeholder="Иванов Иван Иванович"
                        value="<?= htmlspecialchars(get_old_value('full_name')) ?>"
                        required
                    >
                    <small> <?= Validator::validation_error_message('full_name') ?> </small>
                </label>
            </div>
            <div class="form-group">
                <label for="date_of_birth">
                    <p>Дата рождения</p>
                    <input
                        type="date"
                        name="date_of_birth"
                        id="date_of_birth"
                        class="form-control"
                        value="<?= get_old_value('date_of_birth') ?>"
                        required
                    >
                    <small> <?= Validator::validation_error_message('date_of_birth') ?> </small>
                </label>
            </div>
            <div class="form-group">
                <label for="address">
                    <p>Адрес</p>
                    <input
                        type="text"
                        name="address"
                        id="address"
                        class="form-control"
                        placeholder="ул. Поддубного д. 1 кв. 1"
                        value="<?= htmlspecialchars(get_old_value('address')) ?>"
                        required
                    >
                    <small> <?= Validator::validation_error_message('address') ?> </small>
                </label>
            </div>
            <div class="form-group">
                <label for="sex">
                    <p>Пол</p>
                    <select
                        name="sex"
                        id="sex"
                        class="form-control"
                        required
                    >
                        <option value="" disabled selected>Пол</option>
                        <?php $sex = get_old_value('sex') ?>
                        <option value="male" <?= $sex === 'male' ? 'selected' : '' ?>>Мужской</option>
                        <option value="female" <?= $sex === 'female' ? 'selected' : '' ?>>Женский</option>
                    </select>
                    <small> <?= Validator::validation_error_message('sex') ?> </small>
                </label>
            </div>
            <div class="form-group">
                <label for="interests">
                    <p>Интересы</p>
                    <textarea
                        name="interests"
                        id="interests"
                        class="form-control"
                        placeholder="Ваши интересы"
                    ><?= htmlspecialchars(get_old_value('interests')) ?></textarea>
                </label>
            </div>
            <div class="form-group">
                <label for="vk">
                    <p>Ссылка на профиль Вконтакте</p>
                    <input
                        type="url"
                        name="vk"
                        id="vk"
                        class="form-control"
                        placeholder="https://vk.com/idx"
                        value="<?= htmlspecialchars(get_old_value('vk')) ?>"
                        required
                    >
                    <small> <?= Validator::validation_error_message('vk') ?> </small>
                </label>
            </div>
            <div class="form-group">
                <label for="blood_type">
                    <p>Группа крови</p>
                    <select
                        name="blood_type"
                        id="blood_type"
                        class="form-control"
                        required
                    >
                        <option value="" disabled selected>Группа крови</option>
                        <?php $blood_type = get_old_value('blood_type') ?>
                        <option value="1" <?= $blood_type === '1' ? 'selected' : '' ?>>0 (I)</option>
                        <option value="2" <?= $blood_type === '2' ? 'selected' : '' ?>>A (II)</option>
                        <option value="3" <?= $blood_type === '3' ? 'selected' : '' ?>>B (III)</option>
                        <option value="4" <?= $blood_type === '4' ? 'selected' : '' ?>>AB (IV)</option>
                    </select>
                    <small> <?= Validator::validation_error_message('blood_type') ?> </small>
                </label>
            </div>
            <div class="form-group">
                <label for="rh_factor">
                    <p>Резус-фактор</p>
                    <select
                        name="rh_factor"
                        id="rh_factor"
                        class="form-control"
                        required
                    >
                        <option value="" disabled selected>Резус-Фактор</option>
                        <?php $rh_factor = get_old_value('rh_factor') ?>
                        <option value="plus" <?= $rh_factor === 'plus' ? 'selected' : '' ?>>Положительный (+)</option>
                        <option value="minus" <?= $rh_factor === 'minus' ? 'selected' : '' ?>>Отрицательный (-)</option>
                    </select>
                    <small> <?= Validator::validation_error_message('rh_factor') ?> </small>
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
                        value=""
                        required
                    >
                    <small> <?= Validator::validation_error_message('password') ?> </small>
                </label>
            </div>
            <div class="form-group">
                <label for="password_confirm">
                    <p>Подтвердите пароль</p>
                    <input
                        type="password"
                        name="password_confirm"
                        id="password_confirm"
                        class="form-control"
                        placeholder="**********"
                        value=""
                        required
                    >
                    <small> <?= Validator::validation_error_message('password_confirm') ?> </small>
                </label>
            </div>
            <?php if ($registration_errors):?>
                <div class="alert alert-danger">
                    <?php foreach($registration_errors as $error): ?>
                        <?=$error?><br>
                    <?php endforeach?>
                </div>
            <?php endif?>
            <div class="d-flex justify-content-center mb-2">
                <button type="submit" name="signup" class="btn btn-dark">Зарегистрироваться</button>
            </div>
            <div class="form-group">
                <p class="text-center">Уже есть аккаунт? <a href="auth.php">Войти в аккаунт</a></p>
            </div>
        </form>
        <?php endif?>
    </div>
</main>
<?php
unset($_SESSION['validation_errors']);
?>
</body>