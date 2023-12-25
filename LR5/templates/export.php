<!DOCTYPE html>
<html lang="en">
<?php require_once 'head.php'?>
<body>
<?php require_once 'header.php'?>
<div class="container mt-5">
    <form method="post" action="../logic/export_games.php">
        <div class="form-group">
            <label for="path_to_save">Название JSON файла для скачивания</label>
            <input type="text" class="form-control" id="path_to_save" name="file_name" placeholder="games_exported" required>
        </div>
        <button type="submit" class="btn btn-dark">Скачать</button>
    </form>
</div>
</body>