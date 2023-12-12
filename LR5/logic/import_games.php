<?php

require_once 'games_table.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = $_POST['url_to_file'];

    $request = curl_init($url);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($request);

    $games = json_decode($response, true);
//    print_r($games);

    if ($games == null) {
        echo 'Неверный формат файла';
    }
    else {
        foreach ($games as $game) {
            if (
                !isset($game['img']) ||
                !isset($game['name']) ||
                !isset($game['genre']) ||
                !isset($game['description']) ||
                !isset($game['cost'])
            ) {
                echo 'Файл должен содержать поля img, name, genre, description, cost';
                die();
            }
        }

        foreach ($games as $game) {
            $id = $game['id'] ?? null;
            $genre = $game['genre'];
            if ($id == null || !GamesTable::get_game_by_id($id)) {
                GamesTable::create_game(
                    $game['img'],
                    $game['name'],
                    GamesTable::get_genre_id($game['genre']),
                    $game['description'],
                    $game['cost'],
                    $id,
                );
            } else {
                GamesTable::update_game(
                    $id,
                    $game['img'],
                    $game['name'],
                    GamesTable::get_genre_id($game['genre']),
                    $game['description'],
                    $game['cost'],
                );
            }
        }
        $games_count = count(GamesTable::get_games());
        echo "Файл с данными получен из $url и обработан. Создана таблица games и число записей в ней $games_count";
    }
}