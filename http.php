<?php

use Tgu\Ryabova\Blog\Http\Actions\Comments\CreateComment;
use Tgu\Ryabova\Blog\Http\Actions\Posts\DeletePost;
use Tgu\Ryabova\Blog\Http\Actions\Users\CreateUser;
use Tgu\Ryabova\Blog\Http\Actions\Users\FindByUsername;
use Tgu\Ryabova\Blog\Http\ErrorResponse;
use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Ryabova\Exceptions\HttpException;


require_once __DIR__ .'/vendor/autoload.php';
$conteiner = require __DIR__ .'/bootstrap.php';
$request = new Request($_GET,$_SERVER,file_get_contents('php://input'));

try{
    $path=$request->path();
}
catch (HttpException $exception){
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
try {
    $method = $request->method();
}
catch (HttpException $exception){
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
$routes =[
    'GET'=>['/users/show'=>FindByUsername::class,
    ],
    'POST'=>[
        '/users/create'=>CreateUser::class,
    ],
];


if (!array_key_exists($path,$routes[$method])){
    (new ErrorResponse('Not found'))->send();
    return;
}
$actionClassName = $routes[$method][$path];
$action = $conteiner->get($actionClassName);
try {
    $response = $action->handle($request);
    $response->send();
}
catch (Exception $exception){
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
