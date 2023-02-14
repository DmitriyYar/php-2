<?php

namespace Geekbrains\Php2\Http\Actions\Comment;

use Geekbrains\Php2\Blog\Comment;
use Geekbrains\Php2\Blog\Exceptions\HttpException;
use Geekbrains\Php2\Blog\Exceptions\InvalidArgumentException;
use Geekbrains\Php2\Blog\Exceptions\UserNotFoundException;
use Geekbrains\Php2\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Geekbrains\Php2\Blog\UUID;
use Geekbrains\Php2\Http\Actions\ActionInterface;
use Geekbrains\Php2\Http\ErrorResponse;
use Geekbrains\Php2\Http\Request;
use Geekbrains\Php2\Http\Response;
use Geekbrains\Php2\Http\SuccessfulResponse;

class CreateComment implements ActionInterface
{
    // Внедряем репозитории статей и пользователей
    public function __construct(
        private PostsRepositoryInterface $postsRepository,
        private UsersRepositoryInterface $usersRepository,
        private CommentsRepositoryInterface $commentsRepository,
    )
    {
    }

    public function handle(Request $request): Response
    {
        // Находим пользователя
        // Пытаемся создать UUID пользователя из данных запроса
        try {
            $authorUuid = new UUID($request->jsonBodyField('author_uuid'));
        } catch (HttpException|InvalidArgumentException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Пытаемся найти пользователя в репозитории
        try {
            // получаем пользователья из репозитория
            $user = $this->usersRepository->get($authorUuid);
        } catch (UserNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Находим статью
        // Пытаемся создать UUID статьи из данных запроса
        try {
            $postUuid = new UUID($request->jsonBodyField('post_uuid'));
        } catch (HttpException|InvalidArgumentException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Пытаемся найти статью в репозитории
        try {
            // получаем статью из репозитория
            $post = $this->postsRepository->get($postUuid);
        } catch (UserNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Генерируем UUID для нового комментария
        $newCommentUuid = UUID::random();
        try {
            // Пытаемся создать объект статьи
            // из данных запроса
            $comment = new Comment(
                $newCommentUuid,
                $user,
                $post,
                $request->jsonBodyField('text'),
            );
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Сохраняем новую статью в репозитории
        $this->commentsRepository->save($comment);
        // Возвращаем успешный ответ,
        // содержащий UUID нового комментария
        return new SuccessfulResponse([
            'uuid' => (string)$newCommentUuid,
        ]);
    }
}