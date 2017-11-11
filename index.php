<?php

require_once 'vendor/autoload.php';

$app = new \Slim\Slim();
$app->get("/hello/:name", function ($name) {
    echo "Hello " . $name . '<br/>';
});

var_dump($app->request()->params('marta'));

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
    "two" => "[a-zA-Z]*"
]);

$app->group('/api', function () use($app) {
    $app->group('/example', function () use($app) {
        $app->get('/hello(/:name)', function ($name = null) {
            echo 'Hello Bro! My name is ' . $name;
        });

        $app->get('/tell-surname(/:surname)', function ($surname = null) {
            echo 'My surname is ' . $surname;
        });

        $app->get('/me-llamo-Pedro', function () use($app) {
            $app->redirect('/api/example/hello/Pedro');
        });

    });
});

$app->run();