<?php

namespace Tgu\Ryabova\Blog\Http\Actions\Comments;

use Tgu\Ryabova\Blog\Comments;
use Tgu\Ryabova\Blog\Http\Actions\ActionInterface;
use Tgu\Ryabova\Blog\Http\Auth\TokenAuthenticationInterface;
use Tgu\Ryabova\Blog\Http\ErrorResponse;
use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Http\Response;
use Tgu\Ryabova\Blog\Http\SuccessResponse;
use Tgu\Ryabova\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\HttpException;
use Tgu\Ryabova\Exceptions\PostNotFoundException;
use Tgu\Ryabova\Exceptions\UserNotFoundException;

class CreateComment implements ActionInterface
{
    public function __construct(
        private CommentsRepositoryInterface $commentsRepository,
        private TokenAuthenticationInterface $authentication,
    )
    {

    }
    public function handle(Request $request): Response
    {
        try {
            $uuid_author = $this->authentication->user($request);
        } catch (UserNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        try {
            $uuid_post = $this->authentication->post($request);
        } catch (PostNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        $newCommentUuid = UUID::random();
        try {
            $comment = new Comments($newCommentUuid,
                $uuid_post,
                $uuid_author,
                $request->jsonBodyField('textCom')
               );
        } catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        $this->commentsRepository->saveComment($comment);
        return new SuccessResponse(['uuid_comment'=>(string)$newCommentUuid]);

    }

}