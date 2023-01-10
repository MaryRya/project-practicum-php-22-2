<?php

namespace Tgu\Ryabova\PhpUnit\Repositories\UserRepository;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Tgu\Ryabova\Blog\Repositories\UserRepository\SqliteUsersRepository;
use Tgu\Ryabova\Blog\User;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\InvalidArgumentExceptions;
use Tgu\Ryabova\Exceptions\UserNotFoundException;
use Tgu\Ryabova\Person\Name;
use Tgu\Ryabova\PhpUnit\Blog\DummyLogger;

class SqliteUsersRepositoryTest extends TestCase
{
 public function testItTrowsAnExceptionWhenUserNotFound():void
 {
     $connectionStub = $this->createStub(PDO::class);
     $statementStub =  $this->createStub(PDOStatement::class);

     $statementStub->method('fetch')->willReturn(false);
     $connectionStub->method('prepare')->willReturn($statementStub);

     $repository = new SqliteUsersRepository($connectionStub,  new DummyLogger());

     $this->expectException(UserNotFoundException::class);
     $this->expectExceptionMessage('Cannot get user: admin');

     $repository->getByUsername('admin');
 }

    public function testItSaveUserToDB():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':first_name'=>'Petya',
                ':last_name'=>'Petrow',
                ':uuid' =>'cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3',
                ':username'=>'admin',
                ':password'=>'1234'
            ]);
          $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub, new DummyLogger());

        $repository->save(new User(
            new UUID('cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3'),
            new Name('Petya', 'Petrow'), 'admin', '1234'
        ));
    }

    /**
     * @throws UserNotFoundException
     */
    public function testItUUidUser ():User
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub);
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage(' UUID: cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3');

        $repository->getByUuid('cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3');
    }

}