<?php

require_once 'vendor/autoload.php';

$app = new \Slim\Slim();

/** @var mysqli $mysqli */
$db = new mysqli('localhost', 'root', 'root', 'slim_api_rest');

$app->get('/products', function () use($app, $db) {
    $query = $db->query('SELECT * from products');

    $products = [];
    while($row = $query->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
});

$app->run();