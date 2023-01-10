<?php

namespace Tgu\Ryabova\PhpUnit\Blog\Http\Auth;

use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\User;

interface AuthenticationInterface
{
public function user(Request $request): User;
}