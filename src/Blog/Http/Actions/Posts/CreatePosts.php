<?php

namespace Tgu\Ryabova\Blog\Http\Actions\Posts;

use Tgu\Ryabova\Blog\Http\Actions\ActionInterface;
use Tgu\Ryabova\Blog\Http\ErrorResponse;
use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Http\Response;
use Tgu\Ryabova\Blog\Http\SuccessResponse;
use Tgu\Ryabova\Blog\Repositories\PostRepositories\PostsRepositoryInterface;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\HttpException;
use Tgu\Ryabova\Exceptions\PostNotFoundException;

class CreatePosts implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $uuid = UUID::random();
            $id = $request->query('uuid_post');
            $post = $this->postsRepository->getByUuidPost($uuid);
        }
        catch (HttpException | PostNotFoundException $exception ){
            return new ErrorResponse($exception->getMessage());
        }
        $this->postsRepository->savePost($post);
        return new SuccessResponse(['uuid_post'=>$id, 'uuid_author'=>$post->getUuidUser(), 'title'=>$post->getTitle(), 'text'=>$post->getTextPost()]);
    }
}