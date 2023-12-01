<?php
require_once 'db.php';

class GamesTable
{
    public static function get_games(array $filters = [], array $params = []): array {
        $query = 'SELECT games.id, games.img, games.name, genres.name as genre, games.description, games.cost ' .
                 'FROM games join genres on games.genre_id = genres.id';

        if (count($filters) > 0) {
            $query = $query . ' WHERE ' . implode(' AND ', $filters);
            $query .= ' order by games.id;';
        }
        else {
            $query = $query . ' order by games.id;';
        }
        $query = DB::prepare($query);
        $query->execute($params);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get_genres(): array {
        $query = DB::prepare('SELECT * FROM genres order by genres.id');
        $query->execute();
        return $query->fetchAll();
    }
}