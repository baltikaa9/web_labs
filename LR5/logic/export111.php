<?php

require_once 'games_table.php';

$upload_dir = '../upload/';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir);
    }
    $post_file_name = $_POST['file_name'];
    $file_name = (!empty($post_file_name) && preg_match('/\w+/', $post_file_name) ? $post_file_name : 'products_exported') . '.csv';
    $path = $upload_dir . $file_name;

    $products = GamesTable::get_games();
    $fp = fopen($path, 'w');
    //Русские буквы
    fputs($fp, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM
    foreach ($products as $product) {
        fputcsv($fp, $product, ';');
    }

    fclose($fp);

    $url = 'http://localhost/web_labs/LR5/logic/worker.php';
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, [
        'file' => new CURLFile($path, 'application/vnd.ms-excel', $file_name)
    ]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    print_r($response);


    if ($response === false) {
        throw new Exception("Ошибка отправки файла скрипту worker.php");
    }

    curl_close($curl);
}
