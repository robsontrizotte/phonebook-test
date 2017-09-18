<?php
require __DIR__ . '/../vendor/autoload.php';

$router = new \App\Http\Router();

$router->collection()->map('GET', '/', 'App\Http\Controllers\ContactController::index');
$router->collection()->map('GET', '/show/{id}', 'App\Http\Controllers\ContactController::show');
$router->collection()->map('GET', '/delete/{id}', 'App\Http\Controllers\ContactController::delete');
$router->collection()->map('GET', '/new', 'App\Http\Controllers\ContactController::add');
$router->collection()->map('POST', '/save', 'App\Http\Controllers\ContactController::save');

/** API */
$router->collection()->map('GET', '/api/', 'Api\Http\Controllers\ApiContactController::index');
$router->collection()->map('GET', '/api/{id}', 'Api\Http\Controllers\ApiContactController::show');
$router->collection()->map('DELETE', '/api/{id}', 'Api\Http\Controllers\ApiContactController::delete');
$router->collection()->map('POST', '/api/', 'Api\Http\Controllers\ApiContactController::save');
$router->collection()->map('PUT', '/api/{id}', 'Api\Http\Controllers\ApiContactController::save');

try {
    $router->dispatch();
} catch (\Exception $e) {
    var_dump($e);die;
    header('Content-Type: application/json');
    http_response_code($e->getCode());
    $data = ['error' => $e->getMessage()];
    echo json_encode($data);
    exit();
}
