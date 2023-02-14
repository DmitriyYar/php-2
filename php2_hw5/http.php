<?php

use Geekbrains\Php2\Http\Actions\Comment\DeleteComment;
use Geekbrains\Php2\Http\Actions\LikeComment\CreateLikeComment;
use Geekbrains\Php2\Http\Actions\LikePost\CreateLikePost;
use Geekbrains\Php2\Http\Actions\User\DeleteUser;
use Geekbrains\Php2\Http\Actions\Comment\CreateComment;
use Geekbrains\Php2\Http\Actions\Post\CreatePost;
use Geekbrains\Php2\Http\Actions\Post\DeletePost;
use Geekbrains\Php2\Http\Actions\User\CreateUser;
use Geekbrains\Php2\Http\Actions\User\FindByUsername;
use Geekbrains\Php2\Http\ErrorResponse;
use Geekbrains\Php2\Http\Request;

$container = require __DIR__ . '/bootstrap.php';

// Создаём объект запроса из суперглобальных переменных
$request = new Request(
    $_GET,
    $_SERVER,
    file_get_contents('php://input') // тело запроса
);

try {
    $path = $request->path();  // Пытаемся получить путь из запроса
} catch (HttpException) {
    (new ErrorResponse)->send(); //неудачный ответ, если не можем получить путь
    return;
}

try {
// Пытаемся получить HTTP-метод запроса
    $method = $request->method();
} catch (HttpException) {
// Возвращаем неудачный ответ,если по какой-то причине не можем получить метод
    (new ErrorResponse)->send();
    return;
}

$routes = [
    'GET' => [
        '/users/show' => FindByUsername::class,
    ],
    'POST' => [
        '/users/create' => CreateUser::class,
        '/posts/create' => CreatePost::class,
        '/comments/create' => CreateComment::class,
        '/likesPosts/create' => CreateLikePost::class,
        '/likesComments/create' => CreateLikeComment::class,
    ],
    'DELETE' => [
        '/users' => DeleteUser::class,
        '/posts' => DeletePost::class,
        '/comments' => DeleteComment::class,
    ],
];

// Если у нас нет маршрутов для метода запроса - возвращаем неуспешный ответ
if (!array_key_exists($method, $routes)) {
    (new ErrorResponse("Route not found: $method $path"))->send();
    return;
}

// Ищем маршрут среди маршрутов для этого метода
if (!array_key_exists($path, $routes[$method])) {
    (new ErrorResponse("Route not found: $method $path"))->send();
    return;
}

// Выбираем действие по методу и пути
//$action = $routes[$method][$path];

// Получаем имя класса действия для маршрута
$actionClassName = $routes[$method][$path];

// С помощью контейнера создаём объект нужного действия
$action = $container->get($actionClassName);

try {
    $response = $action->handle($request);
    // Отправляем ответ
    $response->send();
} catch (Exception $e) {
    (new ErrorResponse($e->getMessage()))->send();
}
