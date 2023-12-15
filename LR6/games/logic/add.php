<?php
require_once '../logic/helpers.php';
require_once '../logic/games_table.php';

$upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/LR6/inc/catalog_images/';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    validation();
    if (ValidationsErrors::get()) return;

    $photo_name = time() . '_' . $_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . $photo_name);

    GamesTable::create_game(
        $photo_name,
        $_POST['name'],
        (int)$_POST['genre'],
        $_POST['description'],
        (int)$_POST['price'],
    );
    redirect('..');
}

function validation(): void {
    if (!trim($_POST['name'])) ValidationsErrors::add('Не задано название');

    if (!trim($_POST['price'])) ValidationsErrors::add('Не задана цена');
    elseif (!is_numeric($_POST['price']) || (int)$_POST['price'] < 0) ValidationsErrors::add('Неверная цена');

    if (!is_numeric($_POST['genre']) || (int)$_POST['genre'] < 1 || (int)$_POST['genre'] > 5) ValidationsErrors::add('Неверный жанр');

    if ($_FILES['photo']['error']) ValidationsErrors::add('Не выбрано изображение');
    elseif (explode('/', $_FILES['photo']['type'])[0] !== 'image') ValidationsErrors::add('Неверный формат изображения');
}
