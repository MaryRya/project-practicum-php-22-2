<?php

namespace Tgu\Ryabova\Blog\Repositories\CommentsRepository;


use Tgu\Ryabova\Blog\Comments;
use Tgu\Ryabova\Blog\UUID;

interface CommentsRepositoryInterface
{
    public function saveComment(Comments $comment):void;
    public function getByUuidComment(UUID $uuid_comment): Comments;
}

