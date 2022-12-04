<?php

namespace Tgu\Ryabova\Blog\Http\Actions;

use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Http\Response;

interface ActionInterface
{
    public function handle(Request $request):Response;
}
