<?php
require_once 'db.php';

class GamesTable
{
    public static function create_game(
        string $img,
        string $name,
        int $genre_id,
        string $description,
        int $price,
        string $id = null,
    ): void {
        if (!$id) {
            $id = uniqid();
        }

        $query = DB::prepare(
            'INSERT INTO games (id, img, name, genre_id, description, price) ' .
            'VALUES (:id, :img, :name, :genre_id, :description, :price)'
        );

        $query->bindValue(':id', $id);
        $query->bindValue(':img', $img);
        $query->bindValue(':name', $name);
        $query->bindValue(':genre_id', $genre_id);
        $query->bindValue(':description', $description);
        $query->bindValue(':price', $price);

        try {
            $query->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function get_games(array $filters = [], array $params = []): array {
        $query = 'SELECT games.id, games.img, games.name, genres.name as genre, games.description, games.price ' .
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

    public static function get_game_by_id(string $id): array|bool {
        $query = DB::prepare('SELECT * FROM games WHERE id = :id');
        $query->bindValue(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function update_game(
        string $id,
        string $img,
        string $name,
        int $genre_id,
        string $description,
        int $price,
    ): void {
        $query = DB::prepare(
            'UPDATE games SET  img=:img, name=:name, genre_id=:genre_id, description=:description, price=:price 
                      WHERE id=:id'
        );
        $query->bindValue(':id', $id);
        $query->bindValue(':img', $img);
        $query->bindValue(':name', $name);
        $query->bindValue(':genre_id', $genre_id);
        $query->bindValue(':description', $description);
        $query->bindValue(':price', $price);

        try {
            $query->execute();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function get_genres(): array {
        $query = DB::prepare('SELECT * FROM genres order by genres.id');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get_genre_id(string $name): int {
        $query = DB::prepare('SELECT id FROM genres WHERE name = :name');
        $query->bindValue(':name', $name);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC)['id'];
    }
}