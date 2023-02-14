<?php

namespace Geekbrains\Php2\Http\Actions\LikeComment;

use Geekbrains\Php2\Blog\Exceptions\CommentNotFoundException;
use Geekbrains\Php2\Blog\Exceptions\HttpException;
use Geekbrains\Php2\Blog\Exceptions\InvalidArgumentException;
use Geekbrains\Php2\Blog\Exceptions\LikeAlreadyExists;
use Geekbrains\Php2\Blog\Exceptions\PostNotFoundException;
use Geekbrains\Php2\Blog\Exceptions\UserNotFoundException;
use Geekbrains\Php2\Blog\LikeComment;
use Geekbrains\Php2\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\LikesCommentsRepository\LikesCommentsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\PostsRepository\PostsRepositoryInterface;
use Geekbrains\Php2\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Geekbrains\Php2\Blog\UUID;
use Geekbrains\Php2\Http\Actions\ActionInterface;
use Geekbrains\Php2\Http\ErrorResponse;
use Geekbrains\Php2\Http\Request;
use Geekbrains\Php2\Http\Response;
use Geekbrains\Php2\Http\SuccessfulResponse;

class CreateLikeComment implements ActionInterface
{
    // Внедряем репозитории статей и пользователей
    public function __construct(
        private LikesCommentsRepositoryInterface $likesCommentsRepository,
        private CommentsRepositoryInterface $commentsRepository,
        private PostsRepositoryInterface $postsRepository,
        private UsersRepositoryInterface $usersRepository,
    ) {
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        // Из данных POST запроса заполняем переменные UUID
        try {
            $commentUuid = new UUID($request->jsonBodyField('comment_uuid'));
            $postUuid = new UUID($request->jsonBodyField('post_uuid'));
            $userUuid = new UUID($request->jsonBodyField('author_uuid'));
        } catch (HttpException|InvalidArgumentException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Проверяем комментарий в репозитории
        try {
            $this->commentsRepository->get($commentUuid); // получаем комментарий из репозитория
        } catch (CommentNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Проверяем пост в репозитории
        try {
            $this->postsRepository->get($postUuid);
        } catch (PostNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Проверяем пользователя в репозитории
        try {
            $this->usersRepository->get($userUuid); // $user = $this->usersRepository->get($authorUuid);
        } catch (UserNotFoundException $e) {
            return new ErrorResponse($e->getMessage());
        }

        try {
            $this->likesCommentsRepository->checkUserLikeForCommentExists($commentUuid, $userUuid);
        } catch (LikeAlreadyExists $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Генерируем UUID для нового лайка
        $newCommentUuid = UUID::random();

        $likeComment = new LikeComment(
            uuid: $newCommentUuid,
            comment_uuid: new UUID($commentUuid),
            post_uuid: new UUID($postUuid),
            user_uuid: new UUID($userUuid),
        );

        $this->likesCommentsRepository->save($likeComment);

        return new SuccessFulResponse(
            ['uuid' => (string)$newCommentUuid]
        );
    }
}