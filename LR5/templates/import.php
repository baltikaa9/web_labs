<?php

?>
<!DOCTYPE html>
<html lang="en">
<?php require_once 'head.php'?>
<body>
<?php require_once 'header.php'?>
<div class="container mt-5">
    <form action="import_table.php" method="post">
        <div class="form-group">
            <label for="url_to_file">Ссылка на файл</label>
            <input type="url" class="form-control" name="url_to_file" id="url_to_file" placeholder="https://" required="">
        </div>
        <button type="submit" class="btn btn-primary">Загрузить</button>
    </form>
</div>
</body>