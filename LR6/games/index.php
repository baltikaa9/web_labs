<?php
require_once '../logic/games_actions.php';

$games = GamesActions::get_games();
if (!$games) {
    redirect('games.php');
}
$genres = GamesActions::get_genres();
?>
<!DOCTYPE html>
<html lang="ru">
<?php require_once '../templates/head.php'?>
<body>
<?php require_once '../templates/header.php'?>
<main class="content">
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Изображение</th>
                <th scope="col">Название</th>
                <th scope="col">Жанр</th>
                <th scope="col">Описание</th>
                <th scope="col">Цена</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($games as $game):?>
                <tr>
                    <td><img src="../inc/catalog_images/<?=$game['img']?>" alt="..." width="200px"></td>
                    <td><?=htmlspecialchars($game['name'])?></td>
                    <td><?=htmlspecialchars($game['genre'])?></td>
                    <td><?=htmlspecialchars($game['description'])?></td>
                    <td><?=!$game['price'] ? 'Бесплатно' : $game['price'] . ' р.'?></td>
                </tr>
            <?php endforeach?>
            </tbody>
        </table>
        <a type="button" class="btn btn-dark" href="add.php">Добавить</a>
    </div>
</main>
</body>
