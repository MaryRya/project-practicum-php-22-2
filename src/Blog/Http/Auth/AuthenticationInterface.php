<?php

namespace Tgu\Ryabova\Blog\Http\Auth;

use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Post;
use Tgu\Ryabova\Blog\User;

interface AuthenticationInterface
{
    public function user(Request $request):User;
    public function post(Request $request):Post;

}

