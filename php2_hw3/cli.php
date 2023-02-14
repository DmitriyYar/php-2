<?php

use Geekbrains\Php2\Blog\Commands\Arguments;
use Geekbrains\Php2\Blog\Commands\CreateUserCommand;
use Geekbrains\Php2\Blog\Comment;
use Geekbrains\Php2\Blog\Post;
use Geekbrains\Php2\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Geekbrains\Php2\Blog\Repositories\PostsRepository\SqlitePostsRepository;
use Geekbrains\Php2\Blog\Repositories\UsersRepository\InMemoryUsersRepository;
use Geekbrains\Php2\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use Geekbrains\Php2\Blog\UUID;
use Geekbrains\Php2\Person\{Name, User};

// автозагрузчик composer
require_once __DIR__ . '/vendor/autoload.php';

// Создаём объект подключения к SQLite
$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');

// Создаём объекты репозитория
$usersRepository = new SqliteUsersRepository($connection);
$postsRepository = new SqlitePostsRepository($connection);
$commentsRepository = new SqliteCommentsRepository($connection);

// Создаем объект команд командной строки
$command = new CreateUserCommand($usersRepository);

try {
    // добавляем пользователя в репозиторий из терминала
    $command->handle(Arguments::fromArgv($argv)); // php cli.php username=Admin first_name=Ivan last_name=Ivanov

    // Добавляем в репозиторий пользователей
//    $usersRepository->save(new User(UUID::random(), new Name('Olga', 'Romanova'), 'User-1'));
//    $usersRepository->save(new User(UUID::random(), new Name('Anna', 'Petrova'), 'User-2'));
//    $usersRepository->save(new User(UUID::random(), new Name('Igor', 'Fadeev'), 'User-3'));
//    $usersRepository->save(new User(UUID::random(), new Name('Maria', 'Svetlova'), 'User-4'));

    // Получим пользователя из репозитория
//    echo $usersRepository->get(new UUID('5b85ac93-fe75-485d-9a23-9c51981b0a6c'));
//    echo $usersRepository->getByUsername('User-4');

    // создать статью (Post)
//    $userUuid = $usersRepository->get(new UUID('5b85ac93-fe75-485d-9a23-9c51981b0a6c'));
//    $user = $usersRepository->getByUsername('User-4');
//    $postsRepository->save(new Post(UUID::random(), $userUuid, 'Заголовок сатьи', 'Администратор'));
//    $postsRepository->save(new Post(UUID::random(), $user, 'Заголовок сатьи', 'Моя первая статья'));
//    $postsRepository->save(new Post(UUID::random(), $user, 'Заголовок сатьи', 'Моя вторая статья'));

    // получить статью по uuid
//    $post = $postsRepository->get(new UUID('875b2353-cf39-49aa-a662-93dc36571a80'));
//    print_r($post);

    // создать комментарий (Comment)
//    $user = $usersRepository->getByUsername('Admin');
//    $post = $postsRepository->get(new UUID('875b2353-cf39-49aa-a662-93dc36571a80'));
//    $comment = 'Комментарий ко второй статье Светловой М.';
//    $commentsRepository->save(new Comment(UUID::random(), $user, $post, $comment));

    // получить комментарий по uuid
//    $comment = $commentsRepository->get(new UUID('0e1cbfc8-14e4-48a5-b602-20466ad5269c'));
//    print_r($comment);


    // создать пользователя в MemoryUsersRepository
//    $usersRepository = new InMemoryUsersRepository;
//    $user1 = new User(UUID::random(), new Name('Ivan', 'Nikitin'), 'User-1');
//    $user2 = new User(UUID::random(), new Name('Olga', 'Romanova'), 'User-2');
//    $usersRepository->save( $user1);
//    $usersRepository->save( $user2);
//
//    $user = $usersRepository->getByUsername('User-1');
//    print_r($user);

} catch (Exception $e) {
    echo $e->getMessage();
}
