<?php

require_once 'vendor/autoload.php';

$app = new \Slim\Slim();
$app->get("/hello/:name", function ($name) {
    echo "Hello " . $name . '<br/>';
});

$app->get("/tests(/:one(/:two))", function ($one = null, $two = null) {
   echo $one . '<br/>';
   echo $two . '<br/>';
})->conditions([
    "one" => "[a-zA-Z]*",
    "two" => "[0-9]*"
]);

$app->run();