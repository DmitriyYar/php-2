<?php

use GeekBrains\LevelTwo\Blog\Post;
use GeekBrains\LevelTwo\Person\{Name, Person, User};

// Автозагрузчик
spl_autoload_register('load');

function load($className): void
{
    $file = str_replace(
            ['GeekBrains\LevelTwo\\', '\\'],
            ['src\\', DIRECTORY_SEPARATOR],
            $className
        ) . ".php";

    if (file_exists($file)) {
        require_once $file;
    }
}

$name = new Name('Ivan', 'Ivanov');
$user = new User(1, $name, "Admin");
$person = new Person($name, new \DateTimeImmutable());

echo $user . ' ' . $person . PHP_EOL;

$post = new Post(
    1,
    new Person(
        new Name('Иван', 'Никитин'),
        new DateTimeImmutable()
    ),
    'Всем привет!'
);
echo $post;
