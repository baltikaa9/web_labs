<?php
$host = 'localhost';
$port = '3306';
$user = 'root';
$dbname = 'game_discs';
$default_query = 'SELECT games.id, games.img, games.name, genres.name, games.description, games.cost FROM games join genres on games.genre_id = genres.id';

// Create connection
$conn = new mysqli(hostname: $host, username: $user, database: $dbname, port: $port);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

function get_genres_from_db(): array
{
    global $conn;
    $query = 'SELECT * FROM genres order by genres.id';
    $genres = $conn->query($query);
    return $genres->fetch_all();
}

// Creating a query
function create_db_query(string $default_query, array $filters): string {
    if (count($filters) > 0) {
        $query = $default_query . ' WHERE ';
        foreach ($filters as $filter) {
            $query .= $filter;
        }
        $query = substr($query, 0, -5); // Removing "AND" from the end of the query
        $query .= ' order by games.id;';
    }
    else {
        $query = $default_query . ' order by games.id;';
    }
    return $query;
}

$filters = [];

if (isset($_GET['price_from']) and $_GET['price_from'] != '') {
    $filters[] = 'cost >= ' . $_GET['price_from'] . ' AND ';
}

if (isset($_GET['price_to']) and $_GET['price_to'] != '') {
    $filters[] = 'cost <= ' . $_GET['price_to'] . ' AND ';
}

if (isset($_GET['genre']) and !empty($_GET['genre'])) {
    $filters[] = 'genre_id = ' . $_GET['genre'] . ' AND ';
}

if (isset($_GET['description']) and !empty($_GET['description'])) {
    $filters[] = 'description like "%' . $_GET['description'] . '%" AND ';
}

if (isset($_GET['name']) and !empty($_GET['name'])) {
    $filters[] = 'games.name like "%' . $_GET['name'] . '%" AND ';
}


$query = create_db_query($default_query, $filters);
//print_r($query);

$games = $conn->query($query);
$games = $games->fetch_all();
