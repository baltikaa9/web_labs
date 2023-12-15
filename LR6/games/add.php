<?php
require_once '../logic/games_actions.php';
require_once 'logic/add.php';

$genres = GamesActions::get_genres();
$errors = ValidationsErrors::get();
?>
<!DOCTYPE html>
<html lang="ru">
<?php require_once '../templates/head.php'?>
<body>
<?php require_once '../templates/header.php'?>
<main class="content">
    <div class="container">
        <h1>Добавить игру</h1>
        <?php if ($errors):?>
            <div class="alert alert-danger">
                <?php foreach($errors as $error): ?>
                    <?=$error?><br>
                <?php endforeach?>
            </div>
        <?php endif?>
        <form class="row row-cols-lg-auto g-3 align-items-center " name="addGame" method="post" action="add.php" enctype="multipart/form-data">
            <div class="col-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Название" name="name" maxlength="60" title="Название игры" value="<?=htmlspecialchars($_POST['name'] ?? '')?>">
                </div>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Описание" name="description" maxlength="255" title="Описание" value="<?=htmlspecialchars($_POST['description'] ?? '')?>">
                </div>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Цена" name="price" maxlength="60" title="Цена" value="<?=htmlspecialchars($_POST['price'] ?? '')?>">
                </div>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <input type="hidden" name="MAX_FILE_SIZE" value="300000">
                    <input type="file" class="form-control" name="photo" title="Фото">
                </div>
            </div>
            <div class="col-4">
                <div class="input-group">
                    <select class="form-select" aria-label="Жанр" name="genre" title="Жанр">
                        <?php foreach ($genres as $genre):?>
                            <option value="<?=$genre['id']?>"><?=htmlspecialchars($genre['name'])?></option>
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
