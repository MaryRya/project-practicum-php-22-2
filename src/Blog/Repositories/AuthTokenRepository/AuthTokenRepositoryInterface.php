<?php

namespace Tgu\Ryabova\Blog\Repositories\AuthTokenRepository;

use Tgu\Ryabova\Blog\AuthToken;

interface AuthTokenRepositoryInterface
{
public function save(AuthToken $authToken): void;
public function get(string $token): AuthToken;
}