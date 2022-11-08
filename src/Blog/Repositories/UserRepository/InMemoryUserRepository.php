<?php

namespace Tgu\Ryabova\Blog\Repositories\UserRepository;

use Tgu\Ryabova\Blog\User;
use Tgu\Ryabova\Exceptions\UserNotFoundException;

class InMemoryUserRepository
{
private array $users=[];
public function save (User $user):void
{
    $this->users[] =$user;
}
public function get(int $id):User
{
    foreach ($this->users as $user){
        if ($user->getId()=== $id){
            return $user;
        }

    }
    throw new UserNotFoundException("User not found: $id");
}
}