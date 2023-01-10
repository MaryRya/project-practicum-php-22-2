<?php

namespace Tgu\Ryabova\Blog\Http\Actions\Users;

use Tgu\Ryabova\Blog\Http\Actions\ActionInterface;
use Tgu\Ryabova\Blog\Http\ErrorResponse;
use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Http\Response;
use Tgu\Ryabova\Blog\Http\SuccessResponse;
use Tgu\Ryabova\Blog\Repositories\UserRepository\UsersRepositoryInterface;
use Tgu\Ryabova\Blog\User;
use Tgu\Ryabova\Exceptions\HttpException;
use Tgu\Ryabova\Person\Name;

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
           // $newUserUuid = UUID::random();
//            $password = $request->jsonBodyField('password');
//            $hash = hash('sha256', $password);

$user= User::createFrom(
    $request->jsonBodyField('username'),
    $request->jsonBodyField('password'),
    new Name(
        $request->jsonBodyField('first_name'),
        $request->jsonBodyField('last_name')
    )
);

        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->usersRepository->save($user);
        return new SuccessResponse(['uuid'=>(string)$user->getUuid(),
            ]);
    }

}