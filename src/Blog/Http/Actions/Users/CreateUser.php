<?php

namespace Tgu\Ryabova\Blog\Http\Actions\Users;

use Tgu\Ryabova\Blog\Http\Actions\ActionInterface;
use Tgu\Ryabova\Blog\Http\ErrorResponse;
use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Http\Response;
use Tgu\Ryabova\Blog\Http\SuccessResponse;
use Tgu\Ryabova\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Ryabova\Blog\User;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\HttpException;

class CreateUser implements ActionInterface
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $newUserUuid = UUID::random();
            $user = new User($newUserUuid,new Name($request->jsonBodyFind('first_name'), $request->jsonBodyFind('last_name')), $request->jsonBodyFind('username'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->usersRepository->save($user);
        return new SuccessResponse(['uuid'=>(string)$newUserUuid]);
    }

}