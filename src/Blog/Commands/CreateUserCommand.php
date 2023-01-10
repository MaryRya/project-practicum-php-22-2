<?php

namespace Tgu\Ryabova\Blog\Commands;

use Psr\Log\LoggerInterface;
use Tgu\Ryabova\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Ryabova\Blog\User;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\CommandException;
use Tgu\Ryabova\Exceptions\UserNotFoundException;
use Tgu\Ryabova\Person\Name;

class CreateUserCommand
{
    public function __construct(private UsersRepositoryInterface $usersRepository,
    private LoggerInterface $logger,
    )
    {
    }

    public function handle(Arguments $arguments):void{
        $this->logger->info('Create command started');
        $username = $arguments->get('username');
       // $password = $arguments->get('password');
        //$hash = hash('sha256', $password);
        if($this->userExist($username)){
          //  throw new CommandException("User already exists: $username");
            $this->logger->warning("User already exists: $username");
        }

        $user = User::createFrom(
            $username,
            $arguments->get('password'),
            new Name(
                $arguments->get('first_name'),
                $arguments->get('last_name')
            )
        );

       // $uuid= UUID::random();
        $this->usersRepository->save($user);

        $this->logger->info("User created: " . $user->getUuid());
    }
    public function userExist(string $username):bool{
        try{
            $this->usersRepository->getByUsername($username);
        }
        catch (UserNotFoundException $exception){
            return false;
        }
        return true;
    }
}