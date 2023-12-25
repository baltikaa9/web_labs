<?php
require_once '../logic/games_actions.php';
require_once 'logic/edit.php';

$genres = GamesActions::get_genres();
$errors = ValidationsErrors::get();

$game = null;
if (isset($_GET['id'])) {
    $game = GamesTable::get_game_by_id($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="ru">
<?php require_once '../templates/head.php'?>
<body>
<?php require_once '../templates/header.php'?>
<main class="content">
    <div class="container">
        <h1>Изменить игру</h1>
        <?php if ($errors):?>
            <div class="alert alert-danger">
                <?php foreach($errors as $error): ?>
                    <?=$error?><br>
                <?php endforeach?>
            </div>
        <?php endif?>
        <form class="row row-cols-lg-auto g-3 align-items-center " name="addGame" method="post" action="edit.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$_GET['id'] ?? $_POST['id'] ?? null?>">
            <div class="col-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Новое название" name="name" maxlength="60" title="Название игры" value="<?=htmlspecialchars($game['name'] ??
                        $_POST['name'] ?? '')?>">
                </div>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Новое описание" name="description" maxlength="255" title="Описание" value="<?=htmlspecialchars($game['description'] ?? $_POST['description'] ?? '')?>">
                </div>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Новая цена" name="price" maxlength="60" title="Цена" value="<?=htmlspecialchars($game['price'] ?? $_POST['price'] ?? '')?>">
                </div>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <input type="hidden" name="MAX_FILE_SIZE" value="300000">
                    <input type="file" class="form-control" name="photo" title="Новое фото">
                </div>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <select class="form-select" aria-label="Жанр" name="genre" title="Жанр">
                        <?php foreach ($genres as $genre):?>
                            <option value="<?=$genre['id']?>" <?php if (($game && $genre['id'] == $game['genre_id']) || isset($_POST['genre']) && $genre['id'] == $_POST['genre']) echo 'selected'?>><?=htmlspecialchars($genre['name'])?></option>
                        <?php endforeach?>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <button class="btn btn-dark" type="submit">Отправить</button>
            </div>
        </form>
    </div>
</main>
</body>
