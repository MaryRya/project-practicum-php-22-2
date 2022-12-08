<?php

namespace Tgu\Ryabova\Blog\Http\Actions\Likes;

use Tgu\Ryabova\Blog\Http\Actions\ActionInterface;
use Tgu\Ryabova\Blog\Http\Auth\TokenAuthenticationInterface;
use Tgu\Ryabova\Blog\Http\ErrorResponse;
use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Http\Response;
use Tgu\Ryabova\Blog\Http\SuccessResponse;
use Tgu\Ryabova\Blog\Likes;
use Tgu\Ryabova\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\HttpException;
use Tgu\Ryabova\Exceptions\PostNotFoundException;
use Tgu\Ryabova\Exceptions\UserNotFoundException;

class CreateLikes implements ActionInterface
{
    public function __construct(
        private LikesRepositoryInterface $likesRepository,
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
        $newLikeUuid = UUID::random();
        try {
            $like = new Likes($newLikeUuid,
                $uuid_post,
                $uuid_author,
            );
        } catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        $this->likesRepository->saveLike($like);
        return new SuccessResponse(['uuid_like'=>(string)$newLikeUuid]);
//
    }
}