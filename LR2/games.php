<?php
global $games;
require_once 'logic.php';

$genres = get_genres_from_db();
?>
<!DOCTYPE html>
<html lang="ru">
<?php require_once 'head.php' ?>
<body>
<?php require_once 'header.php' ?>
<main class="content">
    <div class="container">
        <form action="games.php" class="filter mb-5">
            <h3 class="text-center">Фильтрация</h3>
            <div class="price-filter">
                <label>
                    <p>По цене:</p>
                    <input name="price_from" type="number" class="form-control mb-3" placeholder="Цена от"
                           value="<?=$_GET['price_from'] ?? ''?>">
                    <input name="price_to" type="number" class="form-control" placeholder="Цена до" pattern="\d+"
                           value="<?=$_GET['price_to'] ?? ''?>">
                </label>
            </div>
            <div class="genre-filter">
                <label>
                    <p>По жанру:</p>
                    <select name="genre" class="form-control" aria-label="Default select example">
                        <option value="" selected>Выберите жанр</option>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?=$genre['id']?>" <?=isset($_GET['genre']) && $genre['id'] == $_GET['genre'] ? 'selected' : ''?>><?=htmlspecialchars($genre['name'])?></option>
                        <?php endforeach?>
                    </select>
                </label>
            </div>
            <div class="name-filter">
                <label>
                    <p>По названию:</p>
                    <input name="name" type="text" class="form-control" placeholder="Введите название"
                           value="<?=isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''?>">
                </label>
            </div>
            <div class="description-filter">
                <label>
                    <p>По описанию:</p>
                    <input name="description" type="text" class="form-control" placeholder="Введите описание"
                           value="<?=isset($_GET['description']) ? htmlspecialchars($_GET['description']) : ''?>">
                </label>
            </div>
            <div class="filter-buttons">
                <button type="submit" name="apply" class="btn btn-primary">Применить фильтр</button>
                <button type="submit" name="clear" class="btn btn-secondary">Очистить фильтр</button>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Изображение</th>
                    <th scope="col">Название</th>
                    <th scope="col">Жанр</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Стоимость</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($games as $game):?>
                    <tr>
                        <td><img src="inc/catalog_images/<?=$game['img']?>" alt="..." width="200px"></td>
                        <td><?=htmlspecialchars($game['name'])?></td>
                        <td><?=htmlspecialchars($game['genre'])?></td>
                        <td><?=htmlspecialchars($game['description'])?></td>
                        <td><?=!$game['cost'] ? 'Бесплатно' : $game['cost'] . ' р.'?></td>
                    </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
</main>
</body>