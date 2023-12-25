<?php

require_once '../../logic/games_actions.php';
require_once '../../logic/helpers.php';

if (isset($_GET['id'])) {
    $game_id = $_GET['id'];

    GamesActions::delete_game($game_id);
    redirect($_SERVER['HTTP_REFERER']);
}
