<?php

namespace Tgu\Ryabova\Blog\Http\Actions\Posts;

use Tgu\Ryabova\Blog\Http\Actions\ActionInterface;
use Tgu\Ryabova\Blog\Http\Auth\TokenAuthenticationInterface;
use Tgu\Ryabova\Blog\Http\ErrorResponse;
use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Http\Response;
use Tgu\Ryabova\Blog\Http\SuccessResponse;
use Tgu\Ryabova\Blog\Post;
use Tgu\Ryabova\Blog\Repositories\PostRepositories\PostsRepositoryInterface;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\HttpException;
use Tgu\Ryabova\Exceptions\UserNotFoundException;

class CreatePost implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository,
        private TokenAuthenticationInterface $authentication,

    )
    {

    }

    /**
     * @throws HttpException
     */
    public function handle(Request $request): Response
    {
     try {
         $uuid_author = $this->authentication->user($request);
    } catch (UserNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
    }


        $newPostUuid = UUID::random();
        try {
            $post = new Post($newPostUuid,
                $uuid_author,
                $request->jsonBodyField('title'),
                $request->jsonBodyField('text'));
        } catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        $this->postsRepository->savePost($post);
        return new SuccessResponse(['uuid_post'=>(string)$newPostUuid]);

    }
}