<?php

namespace Tgu\Ryabova\PhpUnit\Repositories\PostRepositories;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Tgu\Ryabova\Blog\Post;
use Tgu\Ryabova\Blog\Repositories\PostRepositories\SqlitePostsRepository;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\PostNotFoundException;
use Tgu\Ryabova\PhpUnit\Blog\DummyLogger;

class SqlitePostsRepositoryTest extends TestCase
{
    public function testItTrowsAnExceptionWhenPostNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostsRepository($connectionStub, new DummyLogger());

        $this->expectException(PostNotFoundException::class);
        $this->expectExceptionMessage('Cannot get post: vaaaay');

        $repository->getTextPost('vaaaay');
    }

    public function testItSavePostToDB():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':uuid_post' =>'5b78178a-eda3-4e85-9a62-90f5a0320c4e',
                ':uuid_author'=>'f76cfc25-f8b2-4d15-9775-944db6648a82',
                ':title'=>'Title1',
                ':text'=>'vaaaay']);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostsRepository($connectionStub,
            new DummyLogger());

        $repository->savePost(new Post(
            new UUID('5b78178a-eda3-4e85-9a62-90f5a0320c4e'), 'f76cfc25-f8b2-4d15-9775-944db6648a82','Title1','vaaaay'
        ));
    }

    public function testItUUidPosts():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostsRepository($connectionStub, new DummyLogger());

        $this->expectException(PostNotFoundException::class);


        $repository->getByUuidPost('edb10650-3b52-4a8e-b05c-c5a1f167bed0');
    }
}