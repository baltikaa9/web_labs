<?php
require_once 'games_table.php';
require_once 'helpers.php';

class GamesActions
{
    public static function get_games(): ?array {
        if (isset($_GET['apply'])) {
            $fetch = self::fetch_filters();
            $filters = $fetch[0];
            $params = $fetch[1];
            return GamesTable::get_games($filters, $params);
        }
        elseif (isset($_GET['clear'])) {
            return null;
        }
        else {
            return GamesTable::get_games();
        }
    }

    private static function fetch_filters(): array {
        $filters = [];
        $params = [];

        if ($_GET['price_from'] != '') {
            $filters[] = 'cost >= ' . (int) $_GET['price_from'];
        }

        if ($_GET['price_to'] != '') {
            $filters[] = 'cost <= ' . (int) $_GET['price_to'];
        }

        if (!empty($_GET['genre'])) {
            $filters[] = 'genre_id = ' . (int) $_GET['genre'];
        }

        if (!empty($_GET['description'])) {
            $filters[] = 'description like :description';
            $description = $_GET['description'];
            $params[':description'] = "%$description%";
        }

        if (!empty($_GET['name'])) {
            $filters[] = 'games.name like :name';
            $name = $_GET['name'];
            $params[':name'] = "%$name%";
        }
        return [$filters, $params];
    }

    public static function get_genres(): array {
        return GamesTable::get_genres();
    }
}