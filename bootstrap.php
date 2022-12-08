<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Tgu\Ryabova\Blog\Container\DIContainer;
use Tgu\Ryabova\Blog\Http\Auth\BearerTokenAuthentication;
use Tgu\Ryabova\Blog\Http\Auth\PasswordAuthentication;
use Tgu\Ryabova\Blog\Http\Auth\PasswordAuthenticationInterface;
use Tgu\Ryabova\Blog\Http\Auth\TokenAuthenticationInterface;
use Tgu\Ryabova\Blog\Repositories\AuthTokenRepository\AuthTokenRepositoryInterface;
use Tgu\Ryabova\Blog\Repositories\AuthTokenRepository\SqliteAuthTokenRepository;
use Tgu\Ryabova\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Tgu\Ryabova\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Ryabova\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Tgu\Ryabova\Blog\Repositories\LikesRepository\SqliteLikesRepository;
use Tgu\Ryabova\Blog\Repositories\PostRepositories\PostsRepositoryInterface;
use Tgu\Ryabova\Blog\Repositories\PostRepositories\SqlitePostsRepository;
use Tgu\Ryabova\Blog\Repositories\UserRepository\SqliteUsersRepository;
use Tgu\Ryabova\Blog\Repositories\UserRepository\UsersRepositoryInterface;


require_once  __DIR__ . '/vendor/autoload.php';
$conteiner = new DIContainer();
$conteiner->bind(
    PDO::class,
    new PDO('sqlite:'.__DIR__.'/blog.sqlite')
);
$conteiner->bind(
    UsersRepositoryInterface::class,
    SqliteUsersRepository::class
);
$conteiner->bind(
    TokenAuthenticationInterface::class,
    BearerTokenAuthentication::class
);


$conteiner->bind(
    PasswordAuthenticationInterface::class,
    PasswordAuthentication::class
);
$conteiner->bind(
    LikesRepositoryInterface::class,
    SqliteLikesRepository::class
);


$conteiner->bind(
    AuthTokenRepositoryInterface::class,
    SqliteAuthTokenRepository::class
);

$conteiner->bind(
    PostsRepositoryInterface::class,
    SqlitePostsRepository::class
);
//$conteiner->bind(
//    AuthenticationInterface::class,
//    PasswordAuthentication::class
//);
$conteiner->bind(
    CommentsRepositoryInterface::class,
    SqliteCommentsRepository::class
);


$conteiner->bind(
    LoggerInterface::class,
    (new Logger('blog'))->pushHandler(new StreamHandler(
        __DIR__.'/logs/blog.log',
    )) ->pushHandler(new StreamHandler(
        __DIR__.'/logs/blog.error.log',
        level: Logger::ERROR,
        bubble: false
    ))->pushHandler(new StreamHandler( "php://stdout"),
    ),
);
return $conteiner;