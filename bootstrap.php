<?php

use Tgu\Ryabova\Blog\Container\DIContainer;
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
return $conteiner;