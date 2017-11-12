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

$app->post('/products', function () use($db, $app) {
   $query = "INSERT INTO products VALUES (null,"
            ." '{$app->request->post("name")}',"
            ." '{$app->request->post("description")}',"
            ." '{$app->request->post("price")}'"
            .")";
    $insert = $db->query($query);

    if ($insert) {
        $result = ['result' => true, 'message' => 'Product has been added correctly'];
    } else {
        $result = ['result' => false, 'message' => 'Product has NOT been added correctly'];
    }

    echo json_encode($result);
});

$app->run();
