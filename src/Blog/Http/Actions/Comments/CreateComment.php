<?php

namespace Tgu\Ryabova\Blog\Http\Actions\Comments;

use Tgu\Ryabova\Blog\Comments;
use Tgu\Ryabova\Blog\Http\Actions\ActionInterface;
use Tgu\Ryabova\Blog\Http\ErrorResponse;
use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Http\Response;
use Tgu\Ryabova\Blog\Http\SuccessResponse;
use Tgu\Ryabova\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\HttpException;

class CreateComment implements ActionInterface
{
    public function __construct(
        private CommentsRepositoryInterface $commentsRepository
    )
    {

    }

    public function handle(Request $request): Response
    {
        try {
            $newCommentUuid = UUID::random();
            $comment = new Comments($newCommentUuid, $request->jsonBodyFind('uuid_post'), $request->jsonBodyFind('uuid_author'), $request->jsonBodyFind('textCom'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->commentsRepository->saveComment($comment);
        return new SuccessResponse(['uuid'=>(string)$newCommentUuid]);
    }
}