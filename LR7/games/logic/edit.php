<?php
require_once '../logic/helpers.php';
require_once '../logic/games_actions.php';

$upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/LR7/inc/catalog_images/';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    validation();
    if (ValidationsErrors::get()) return;

    $photo_name = null;
    if ($_FILES['photo']['error'] != 4) {
        $photo_name = time() . '_' . $_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], $upload_dir . $photo_name);
    }

    GamesActions::update_game(
        $_POST['id'],
        $photo_name,
        !$_POST['name'] ? null : $_POST['name'],
        !$_POST['genre'] ? null : (int)$_POST['genre'],
        !$_POST['description'] ? null : $_POST['description'],
        !$_POST['price'] ? null : (int)$_POST['price'],
    );
    redirect('..');
}

function validation(): void {
    if (!isset($_POST['price']) && (!is_numeric($_POST['price']) || (int)$_POST['price'] < 0)) ValidationsErrors::add('Неверная цена');

    if (!is_numeric($_POST['genre']) || (int)$_POST['genre'] < 1 || (int)$_POST['genre'] > 5) ValidationsErrors::add('Неверный жанр');

    if (!$_FILES['photo']['error'] && explode('/', $_FILES['photo']['type'])[0] !== 'image') ValidationsErrors::add('Неверный формат изображения');
}
