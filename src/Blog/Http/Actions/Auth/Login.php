<?php

namespace Tgu\Ryabova\Blog\Http\Actions\Auth;


use Tgu\Ryabova\Blog\AuthToken;
use Tgu\Ryabova\Blog\Http\Actions\ActionInterface;
use Tgu\Ryabova\Blog\Http\Auth\PasswordAuthenticationInterface;
use Tgu\Ryabova\Blog\Http\ErrorResponse;
use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Http\Response;
use Tgu\Ryabova\Blog\Http\SuccessResponse;
use Tgu\Ryabova\Blog\Repositories\AuthTokenRepository\AuthTokenRepositoryInterface;
use Tgu\Ryabova\Exceptions\AuthException;

class Login implements ActionInterface
{
public function __construct(
    private PasswordAuthenticationInterface $passwordAuthentication,
    private AuthTokenRepositoryInterface $authTokenRepository,
)
{
}

    public function handle(Request $request): Response
    {
        try {
            $user = $this->passwordAuthentication->user($request);
        }catch (AuthException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $authToken = new AuthToken(
            bin2hex(random_bytes(40)),
            $user->getUuid(),
            (new \DateTimeImmutable())->modify('+1 day')
        );
        $this->authTokenRepository->save($authToken);
        return new SuccessResponse([
            'token' =>(string)$authToken,
        ]);
    }
}