<?php

namespace Tgu\Ryabova\PhpUnit\Blog\Http\Actions\Posts;

use PHPUnit\Framework\TestCase;
use Tgu\Ryabova\Blog\Http\Actions\Posts\CreatePosts;
use Tgu\Ryabova\Blog\Http\ErrorResponse;
use Tgu\Ryabova\Blog\Http\Request;
use Tgu\Ryabova\Blog\Http\SuccessResponse;
use Tgu\Ryabova\Blog\Post;
use Tgu\Ryabova\Blog\Repositories\PostRepositories\PostsRepositoryInterface;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\PostNotFoundException;

class CreatePostActionTest extends TestCase
{
    private function postRepository(array $posts):PostsRepositoryInterface{
        return new class($posts) implements PostsRepositoryInterface {
            public function __construct(
                public array $array
            )
            {
            }

            public function savePost(Post $post): void
            {
                // TODO: Implement save() method.
            }

            public function getByUuidPost(UUID $uuid): Post
            {
                throw new PostNotFoundException('Not found');
            }
        };
    }


    public function testItReturnErrorResponceIfNoUuid(): void
    {
        $request = new Request([], [], '');
        $postRepository = $this->postRepository([]);
        $action = new CreatePosts($postRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $responce);
        $this->expectOutputString('{"success":false,"reason":"No such query param in the request uuid_post"}');
        $responce->send();
    }


    public function testItReturnErrorResponceIfUUIDNotFound(): void{
        $uuid = UUID::random();
        $request = new Request(['uuid_post'=>$uuid], [], '');
        $userRepository = $this->postRepository([]);
        $action = new CreatePosts($userRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $responce);
        $this->expectOutputString('{"success":false,"reason":"Not found"}');
        $responce->send();
    }

    /**
     * @throws \JsonException
     */
    public function testItReturnSuccessfulResponse(): void{
        $uuid = UUID::random();
        $request = new Request(['uuid_post'=>"$uuid"], [],'');
        $postRepository = $this->postRepository([new Post($uuid,'cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3','Title1','vaaaay')]);
        $action = new CreatePosts($postRepository);
        $responce = $action->handle($request);
        var_dump($responce);
        $this->assertInstanceOf(SuccessResponse::class, $responce);
        $this->expectOutputString('{"success":true,"data":{"uuid_post":"Petya"}}');
        $responce->send();
    }
}