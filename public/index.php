<?php
require __DIR__ . '/../vendor/autoload.php';

$router = new \App\Http\Router();

$router->collection()->map('GET', '/', 'App\Http\Controllers\ContactController::index');

$router->dispatch();
