<?php

use Geekbrains\Php2\Blog\{Post, Comments};
use Geekbrains\Php2\Person\{Name, Person, User};

// автозагрузчик composer
require_once __DIR__ . '/vendor/autoload.php';

$faker = Faker\Factory::create('ru_RU');

$name = new Name($faker->firstName('female'), $faker->lastName('female'));
$user = new User(1, $name, ucfirst($faker->word()));
$post = new Post(1, $user, $faker->realText(rand(10, 15)), $faker->realText(rand(150, 300)));
$comment = new Comments(1, $user, $post, $faker->realText(30));

$route = $argv[1] ?? null;

switch ($route) {
    case 'user':
        echo $user->getUsername() . PHP_EOL;
        break;
    case 'post':
        echo $post . PHP_EOL;
        break;
    case 'comment':
        echo $comment . PHP_EOL;
        break;
    default:
        echo 'error try (user post comment) parametr.';
}
