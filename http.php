<?php
$http = new Swoole\Http\Server('0.0.0.0', 9502);

$http->on('Request', function ($request, $response) {
    print_r($request);
    $response->header('Content-Type', 'text/html; charset=utf-8');
    $response->end('<h1>Hello Swoole. #' . rand(1000, 9999) . '</h1>');
});

$http->start();