<?php

namespace Tgu\Ryabova\Blog\Repositories\PostRepositories;

use Tgu\Ryabova\Blog\Post;
use Tgu\Ryabova\Blog\UUID;

interface PostsRepositoryInterface
{
    public function savePost(Post $post):void;
    public function getByUuidPost(UUID $uuidPost): Post;
    public function getTextPost(string $text):Post;


}
