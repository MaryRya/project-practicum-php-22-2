<?php

namespace Tgu\Ryabova\Blog\Repositories\PostRepositories;

use Tgu\Ryabova\Blog\Post;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\PostNotFoundException;

class InMemoryPostRepository implements PostsRepositoryInterface
{
    private array $posts = [];

    public function savePost(Post $post):void{
        $this->posts[] = $post;
    }

    public function getByUuidPost(UUID $uuidPost): Post
    {
        foreach ($this->posts as $post){
            if((string)$post->getUuid() === $uuidPost)
                return $post;
        }
        throw new PostNotFoundException("Posts not found $uuidPost");
    }
}