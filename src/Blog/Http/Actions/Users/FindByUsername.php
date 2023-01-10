<?php

namespace Tgu\Ryabova\Blog\Http\Actions\Users;

use Tgu\Ryabova\Blog\Http\Auth\AuthenticationInterface;
use Tgu\Ryabova\Blog\Http\ErrorResponse;
use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Http\Response;
use Tgu\Ryabova\Blog\Http\SuccessResponse;
use Tgu\Ryabova\Blog\Post;
use Tgu\Ryabova\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Ryabova\Blog\User;
use Tgu\Ryabova\Exceptions\HttpException;
use Tgu\Ryabova\Exceptions\UserNotFoundException;

class FindByUsername implements AuthenticationInterface
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $username = $request->query('username');
            $user =$this->usersRepository->getByUsername($username);
        }
        catch (HttpException | UserNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        return new SuccessResponse(['username'=>$user->getUserName(),'name'=>$user->getName()->getFirstName().' '.$user->getName()->getLastName()]);
    }

    public function user(Request $request): User
    {
        // TODO: Implement user() method.
    }

    public function post(Request $request): Post
    {
        // TODO: Implement post() method.
    }
}