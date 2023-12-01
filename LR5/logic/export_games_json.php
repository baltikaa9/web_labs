<?php
require_once 'games_table.php';

$upload_dir = '../upload/';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir);
    }
    $post_file_name = $_POST['file_name'];
    $file_name = (!empty($post_file_name) && preg_match('/\w+/', $post_file_name) ? $post_file_name : 'games_exported') . '.json';
    $path = $upload_dir . $file_name;
//    echo $path;

    $games = GamesTable::get_games();
    $games_json = json_encode($games, JSON_UNESCAPED_UNICODE);
    file_put_contents($path, $games_json);

    header('Content-Type: application/json');
    header("Content-Disposition: attachment; filename=$file_name");
    readfile($path);

    unlink($path);
}
