<?php

use Geekbrains\Php2\Blog\Commands\Arguments;
use Geekbrains\Php2\Blog\Commands\CreateUserCommand;
use Geekbrains\Php2\Blog\Comment;
use Geekbrains\Php2\Blog\Post;
use Geekbrains\Php2\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Geekbrains\Php2\Blog\Repositories\LikesCommentsRepository\LikesCommentsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\LikesPostsRepository\LikesPostsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\PostsRepository\SqlitePostsRepository;
use Geekbrains\Php2\Blog\Repositories\UsersRepository\InMemoryUsersRepository;
use Geekbrains\Php2\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use Geekbrains\Php2\Blog\UUID;
use Geekbrains\Php2\Person\{Name, User};

$container = require __DIR__ . '/bootstrap.php';

try {

    // При помощи контейнера создаём команду
//    $command = $container->get(CreateUserCommand::class);
//    $command->handle(Arguments::fromArgv($argv));


    // добавляем пользователя в репозиторий из терминала
    //$command->handle(Arguments::fromArgv($argv)); // php cli.php username=Admin first_name=Ivan last_name=Ivanov

    // Получим репозиторий пользователей
//    $usersRepository = $container->get(SqliteUsersRepository::class);
    // Добавляем в репозиторий пользователей
//    $usersRepository->save(new User(UUID::random(), new Name('Olga', 'Romanova'), 'User-8'));
//    $usersRepository->save(new User(UUID::random(), new Name('Anna', 'Petrova'), 'User-2'));
//    $usersRepository->save(new User(UUID::random(), new Name('Igor', 'Fadeev'), 'User-3'));
//    $usersRepository->save(new User(UUID::random(), new Name('Maria', 'Svetlova'), 'User-4'));

    // Получим пользователя из репозитория
//    echo $usersRepository->get(new UUID('5b85ac93-fe75-485d-9a23-9c51981b0a6c'));
//    echo $usersRepository->getByUsername('User-4');
//    echo $container->get(SqliteUsersRepository::class)->getByUsername('User-4');

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


//    $likesCommentsRepository = $container->get(LikesCommentsRepositoryInterface::class);
//    $likesComments = $likesCommentsRepository->getByCommentUuid(new UUID('de92b49f-0d1a-4662-ab6d-5e8f1dbece4d'));
//    print_r($likesComments);

    $likesPostsRepository = $container->get(LikesPostsRepositoryInterface::class);
    $likesPosts = $likesPostsRepository->getByPostUuid(new UUID('875b2353-cf39-49aa-a662-93dc36571a80'));
    print_r($likesPosts);

//    $postsRepository = $container->get(PostsRepositoryInterface::class);
//    $posts = $postsRepository->get(new UUID('b6acb64c-3761-49f5-8bcc-d70538822fbe'));
//    print_r($posts);


} catch (Exception $e) {
    echo $e->getMessage();
}
