<?php
namespace Tgu\Ryabova\Blog\Repositories\LikesRepository;

use Tgu\Ryabova\Blog\Likes;

interface LikesRepositoryInterface
{
    public function saveLike(Likes $comment):void;
    public function getByPostUuid(string $uuid_post): Likes;
}