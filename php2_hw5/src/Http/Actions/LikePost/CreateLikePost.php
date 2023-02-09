<?php

namespace Geekbrains\Php2\Http\Actions\LikePost;

use Geekbrains\Php2\Blog\Exceptions\HttpException;
use Geekbrains\Php2\Blog\Exceptions\InvalidArgumentException;
use Geekbrains\Php2\Blog\Exceptions\LikeAlreadyExists;
use Geekbrains\Php2\Blog\Exceptions\PostNotFoundException;
use Geekbrains\Php2\Blog\Exceptions\UserNotFoundException;
use Geekbrains\Php2\Blog\LikePost;
use Geekbrains\Php2\Blog\Repositories\LikesPostsRepository\LikesPostsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Geekbrains\Php2\Blog\UUID;
use Geekbrains\Php2\Http\Actions\ActionInterface;
use Geekbrains\Php2\Http\ErrorResponse;
use Geekbrains\Php2\Http\Request;
use Geekbrains\Php2\Http\Response;
use Geekbrains\Php2\Http\SuccessfulResponse;

class CreateLikePost implements ActionInterface
{
    // Внедряем репозитории
    public function __construct(
        private LikesPostsRepositoryInterface $likesPostsRepository,
        private PostsRepositoryInterface      $postsRepository,
        private UsersRepositoryInterface      $usersRepository,
    ) {
    }

    public function handle(Request $request): Response
    {
        // Пытаемся создать UUID из данных запроса
        try {
            $userUuid = new UUID($request->jsonBodyField('author_uuid'));
            $postUuid = new UUID($request->jsonBodyField('post_uuid'));
        } catch (HttpException|InvalidArgumentException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Проверяем пост в репозитории
        try {
            $post = $this->postsRepository->get($postUuid); // получаем комментарий из репозитория
        } catch (PostNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Проверяем пользователя в репозитории
        try {
            $user = $this->usersRepository->get($userUuid); // получаем комментарий из репозитория
        } catch (UserNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // проверка лайков в репозитории
        try {
            $this->likesPostsRepository->checkUserLikeForPostExists($postUuid, $userUuid);
        } catch (LikeAlreadyExists $e) {
            return new ErrorResponse($e->getMessage());
        }
        // Генерируем UUID для нового лайка
        $newLikePostUuid = UUID::random();

        try {
            // Пытаемся создать объект статьи из данных запроса
            $likePost = new LikePost(
                uuid: $newLikePostUuid,
                post: $post,
                user: $user,
            );
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        $this->likesPostsRepository->save($likePost);

        return new SuccessFulResponse(
            ['uuid' => (string)$newLikePostUuid]
        );
    }
}