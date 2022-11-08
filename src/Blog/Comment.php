<?php

namespace Tgu\Ryabova\Blog;

class Comment
{
public function __construct(
    private int $idComm,
    private Name $idUser,
    private Post $idPost,
    private string $text,
)
{

}
    public function __toString(): string
    {
        return $this->idComm . ' ' .$this->idUser . ' ' .$this->idPost . ' ' . $this->text;
    }
}