<?php
$host = 'localhost';
$port = '3306';
$user = 'root';
$dbname = 'game_discs';
$default_query = 'SELECT games.id, games.img, games.name, genres.name as genre, games.description, games.cost FROM games join genres on games.genre_id = genres.id';

// Create connection
try {
    $pdo = new PDO('mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname, $user);
}
catch (PDOException $exception) {
    die($exception->getMessage());
}

function get_genres_from_db(): array {
    global $pdo;
    $query = 'SELECT * FROM genres order by genres.id';
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Creating a query
function create_db_query(string $default_query, array $filters): string {
    if (count($filters) > 0) {
        $query = $default_query . ' WHERE ' . implode(' AND ', $filters);
        $query .= ' order by games.id;';
    }
    else {
        $query = $default_query . ' order by games.id;';
    }
    return $query;
}

$filters = [];

if (isset($_GET['apply'])) {
    if (isset($_GET['price_from']) and $_GET['price_from'] != '') {
        $filters[] = 'cost >= ' . (int) $_GET['price_from'];
    }

    if (isset($_GET['price_to']) and $_GET['price_to'] != '') {
        $filters[] = 'cost <= ' . (int) $_GET['price_to'];
    }

    if (isset($_GET['genre']) and !empty($_GET['genre'])) {
        $filters[] = 'genre_id = ' . (int) $_GET['genre'];
    }

    if (isset($_GET['description']) and !empty($_GET['description'])) {
        $filters[] = 'description like "%' . $_GET['description'] . '%"';
    }

    if (isset($_GET['name']) and !empty($_GET['name'])) {
        $filters[] = 'games.name like "%' . $_GET['name'] . '%"';
    }
}
elseif (isset($_GET['clear'])) {
    header("Location: games.php");
}

$query = create_db_query($default_query, $filters);
//print_r($query);

$stmt = $pdo->prepare($query);
$stmt->execute();
$games = $stmt->fetchAll();
