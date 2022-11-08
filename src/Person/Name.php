<?php

namespace Tgu\Ryabova\Person;

class Name{
public function __construct(
    private int $idUser,
    private string $firstName,
    private string $lastName,

)
{

}
public function __toString(): string
{
    return $this->idUser . ' ' .$this->firstName . ' ' . $this->lastName;
}
}