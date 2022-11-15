<?php

namespace Tgu\Ryabova\Blog\Repositories\CommentsRepository;

use Tgu\Ryabova\Blog\Comments;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\CommentNotFoundException;

class InMemoryCommentsRepository implements CommentsRepositoryInterface
{
    private array $comments = [];

    public function saveComment(Comments $comment):void{
        $this->comments[] = $comment;
    }

    public function getByUuidComment(UUID $uuid_comment): Comments
    {
        foreach ($this->comments as $comment){
            if((string)$comment->getUuid() === $uuid_comment)
                return $comment;
        }
        throw new CommentNotFoundException("Users not found $uuid_comment");
    }
}
