<?php

namespace Tgu\Ryabova\PhpUnit\Repositories\CommentsRepository;

use http\Exception\InvalidArgumentException;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Tgu\Ryabova\Blog\Comments;
use Tgu\Ryabova\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\CommentNotFoundException;
use Tgu\Ryabova\PhpUnit\Blog\DummyLogger;

class SqliteCommentsRepositoryTest extends TestCase
{
    public function testItTrowsAnExceptionWhenCommentNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub, new DummyLogger());

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Cannot get comment: Qooooo');

        $repository->getTextComment('Qooooo');
    }

    public function testItSaveCommentsToDB():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':uuid_comment' =>'f165d492-bffe-448f-a499-b72d16a40f1b',
                ':uuid_post'=>'edb10650-3b52-4a8e-b05c-c5a1f167bed0',
                ':uuid_author'=>'f76cfc25-f8b2-4d15-9775-944db6648a82',
                ':textCom'=>'Qooooo'
            ]);

        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub,
            new DummyLogger());

        $repository->saveComment( new Comments(
            new UUID('f165d492-bffe-448f-a499-b72d16a40f1b'), 'edb10650-3b52-4a8e-b05c-c5a1f167bed0','f76cfc25-f8b2-4d15-9775-944db6648a82','Qooooo'
            ));
    }

    public function testItUUidComments():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);


        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub, new DummyLogger());

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Cannot get comment:f165d492-bffe-448f-a499-b72d16a40f1b');

         $repository->getByUuidComment('f165d492-bffe-448f-a499-b72d16a40f1b');
    }
}