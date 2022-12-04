<?php

namespace Tgu\Ryabova\Blog\Repositories\UserRepository;

use Tgu\Ryabova\Blog\User;
use Tgu\Ryabova\Blog\UUID;

interface UsersRepositoryInterface
{
    public function save(User $user):void;
    public function getByUsername(string $username):User;
    public function getByUuid(UUID $uuid): User;
}
