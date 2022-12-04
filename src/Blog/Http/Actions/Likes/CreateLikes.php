<?php

namespace Tgu\Ryabova\Blog\Http\Actions\Likes;

use Tgu\Ryabova\Blog\Http\Actions\ActionInterface;
use Tgu\Ryabova\Blog\Http\ErrorResponse;
use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Http\Response;
use Tgu\Ryabova\Blog\Http\SuccessResponse;
use Tgu\Ryabova\Blog\Likes;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\HttpException;

class CreateLikes implements ActionInterface
{
    public function __construct(
        private LikesRepositoryInterface $likesRepository
    )
    {
    }
    public function handle(Request $request): Response
    {
        try {
            $newLikeUuid = UUID::random();
            $like= new Likes($newLikeUuid, $request->jsonBodyFind('uuid_post'), $request->jsonBodyFind('uuid_user'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->likesRepository->saveLike($like);
        return new SuccessResponse(['uuid_like'=>(string)$newLikeUuid]);
    }
}