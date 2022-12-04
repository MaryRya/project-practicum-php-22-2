<?php

namespace Tgu\Ryabova\Blog\Http\Actions\Posts;

use Tgu\Ryabova\Blog\Http\Actions\ActionInterface;
use Tgu\Ryabova\Blog\Http\ErrorResponse;
use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Http\Response;
use Tgu\Ryabova\Blog\Http\SuccessResponse;
use Tgu\Ryabova\Blog\Post;
use Tgu\Ryabova\Blog\Repositories\PostRepositories\PostsRepositoryInterface;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\HttpException;

class CreatePost implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository
    )
    {

    }

    public function handle(Request $request): Response
    {
        try {
            $newPostUuid = UUID::random();
            $post = new Post($newPostUuid, $request->jsonBodyFind('uuid_author'), $request->jsonBodyFind('title'), $request->jsonBodyFind('text'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->postsRepository->savePost($post);
        return new SuccessResponse(['uuid_post'=>$newPostUuid]);
    }
}