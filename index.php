<?php

require_once 'vendor/autoload.php';

$app = new \Slim\Slim();
$app->get("/hello/:name", function ($name) {
    echo "Hello " . $name . '<br/>';
});

function test_middle() {
    echo 'I\'m a middleware' . '<br/>';
}

function test_middle2() {
    echo 'I\'m another middleware :)' . '<br/>';
}

$app->get("/tests(/:one(/:two))", 'test_middle', 'test_middle2', function ($one = null, $two = null) {
   echo $one . '<br/>';
   echo $two . '<br/>';
})->conditions([
    "one" => "[a-zA-Z]*",
    "two" => "[0-9]*"
]);

$app->run();