<?php

use Geekbrains\Php2\Blog\Container\DIContainer;
use Geekbrains\Php2\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Geekbrains\Php2\Blog\Repositories\LikesCommentsRepository\LikesCommentsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\LikesCommentsRepository\SqliteLikesCommentsRepository;
use Geekbrains\Php2\Blog\Repositories\LikesPostsRepository\LikesPostsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\LikesPostsRepository\SqliteLikesPostsRepository;
use Geekbrains\Php2\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\PostsRepository\SqlitePostsRepository;
use Geekbrains\Php2\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use Geekbrains\Php2\Blog\Repositories\UsersRepository\UsersRepositoryInterface;

//вынесем в файл bootstrap.php общее из файлов cli.php и http.php

// автозагрузчик composer
require_once __DIR__ . '/vendor/autoload.php';

// Создаём объект контейнера
$container = new DIContainer();

// настраиваем объект контейнера:
// подключение к БД в $container сохраняем объект PDO
$container->bind(
    PDO::class,
    new PDO('sqlite:' . __DIR__ . '/blog.sqlite')
);

// сохраним репозиторий пользователей
$container->bind(
    UsersRepositoryInterface::class,
    SqliteUsersRepository::class
);

// сохраним репозиторий статей
$container->bind(
    PostsRepositoryInterface::class,
    SqlitePostsRepository::class
);

// сохраним репозиторий комментариев
$container->bind(
    CommentsRepositoryInterface::class,
    SqliteCommentsRepository::class
);

// сохраним репозиторий лайков
$container->bind(
    LikesCommentsRepositoryInterface::class,
    SqliteLikesCommentsRepository::class
);

// сохраним репозиторий лайков
$container->bind(
    LikesPostsRepositoryInterface::class,
    SqliteLikesPostsRepository::class
);

// Возвращаем объект контейнера
return $container;