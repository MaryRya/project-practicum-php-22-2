<?php

use Psr\Log\LoggerInterface;
use Tgu\Ryabova\Blog\Commands\Arguments;
use Tgu\Ryabova\Blog\Commands\CreateUserCommand;
use Tgu\Ryabova\Exceptions\Argumentsexception;
use Tgu\Ryabova\Exceptions\CommandException;

$conteiner = require __DIR__ .'/bootstrap.php';


$command = $conteiner->get(CreateUserCommand::class);

$logger= $conteiner-> get(LoggerInterface::class);
try{$command->handle(Arguments::fromArgv($argv));}
catch (Argumentsexception|CommandException $exception){
    $logger->error($exception->getMessage(),['exceptoin'=>$exception]);
}
