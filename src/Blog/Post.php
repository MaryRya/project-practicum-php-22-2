<?php
namespace Tgu\Ryabova\Blog;

use Tgu\Ryabova\Person\Person;

class Post
{
public function __construct(
    private Person $person,
    private string $text,
    private int $idPost,
    private Name $idUser,
    private string $title,

)
{
}
public function __toString(): string
{
    return $this->id . ' ' .$this->idAuth . ' ' .$this->title . ' ' . $this->text;
}
}