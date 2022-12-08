<?php

namespace Tgu\Ryabova\Blog\Http\Auth;

use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Post;
use Tgu\Ryabova\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Ryabova\Blog\User;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\AuthException;
use Tgu\Ryabova\Exceptions\HttpException;
use Tgu\Ryabova\Exceptions\InvalidArgumentExceptions;
use Tgu\Ryabova\Exceptions\UserNotFoundException;

class PasswordAuthentication implements PasswordAuthenticationInterface
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository,
    )
    {

    }

    /**
     * @throws AuthException
     */
    public function user(Request $request): User
    {
        try {
            $username = new UUID($request->jsonBodyField('username'));
        }catch (InvalidArgumentExceptions | HttpException$exception){
            throw new AuthException($exception->getMessage());
        }
        try {
            $user = $this->usersRepository->getByUsername($username);
        }catch (UserNotFoundException $exception){
            throw new AuthException($exception->getMessage());
        }
        try {
            $password = $request->jsonBodyField('password');
        }catch (InvalidArgumentExceptions | HttpException$exception){
            throw new AuthException($exception->getMessage());
        }


      if (!$user->checkPassword($password)){
           throw new AuthException('Wrong password');
      }
             return $user;
    }

    public function post(Request $request): Post
    {
        // TODO: Implement post() method.
    }
}