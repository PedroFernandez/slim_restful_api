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

$app->put('/products/:id', function ($id) use($db, $app) {

    $query = "UPDATE products SET "
             ."name = '{$app->request->post("name")}',"
             ."description = '{$app->request->post("description")}',"
             ."price = '{$app->request->post("price")}'"
             ."WHERE id = '{$id}' ";

    $update = $db->query($query);

    if ($update) {
        $result = ['result' => true, 'message' => 'Product has been updated correctly'];
    } else {
        $result = ['result' => false, 'message' => 'Product has NOT been updated correctly'];
    }

    echo json_encode($result);
});

$app->delete('/products/:id', function ($id) use($db, $app) {
    $query = "DELETE FROM products WHERE id = {$id}";

    $delete = $db->query($query);

    if(!$delete) {
        $result = ['result' => false, 'message' => 'Product has NOT been deleted correctly'];
        echo json_encode($result);
        exit;
    }

    $result = ['result' => true, 'message' => 'Product has been deleted correctly'];
    echo json_encode($result);
});

$app->run();
