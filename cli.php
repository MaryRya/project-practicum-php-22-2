<?php

use Tgu\Ryabova\Blog\Comments;
use Tgu\Ryabova\Blog\Post;
use Tgu\Ryabova\Blog\Repositories\PostRepositories\SqlitePostsRepository;
use Tgu\Ryabova\Blog\UUID;

//use Tgu\Ryabova\Blog\Repositories\UserRepository\SqliteUsersRepository;
//use Tgu\Ryabova\Blog\User;

require_once __DIR__.'/vendor/autoload.php';
$connection=new PDO('sqlite:'.__DIR__.'/blog.sqlite');
//$userRepository = new SqliteUsersRepository($connection);
//$userRepository->save(new User(\Tgu\Ryabova\Blog\UUID::random(), new \Tgu\Ryabova\Person\Name('Petya', 'Petrow'),'admin'));
//$userRepository->save(new User(\Tgu\Ryabova\Blog\UUID::random(), new \Tgu\Ryabova\Person\Name('Anya', 'Radostova'),'user1'));
//echo $userRepository->getByUuid(new \Tgu\Ryabova\Blog\UUID('f76cfc25-f8b2-4d15-9775-944db6648a82'));
//$PostRepository = new SqlitePostsRepository($connection);
//$PostRepository->savePost(new Post(\Tgu\Ryabova\Blog\UUID::random(),'cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3','Title1','vaaaay'));
//$PostRepository->savePost(new Post(\Tgu\Ryabova\Blog\UUID::random(), 'f76cfc25-f8b2-4d15-9775-944db6648a82', 'title2','Happy New Year'));
//echo $PostRepository->getByUuidPost(new \Tgu\Ryabova\Blog\UUID('edb10650-3b52-4a8e-b05c-c5a1f167bed0'));
$CommentsRepository = new \Tgu\Ryabova\Blog\Repositories\CommentsRepository\SqliteCommentsRepository($connection);
$CommentsRepository->saveComment(new Comments(UUID::random(),'edb10650-3b52-4a8e-b05c-c5a1f167bed0', 'f76cfc25-f8b2-4d15-9775-944db6648a82','Qooooo'));
$CommentsRepository->saveComment(new Comments(UUID::random(), '5b78178a-eda3-4e85-9a62-90f5a0320c4e', 'cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3','Yes!!!'));
echo $CommentsRepository->getByUuidComment(new \Tgu\Ryabova\Blog\UUID('f165d492-bffe-448f-a499-b72d16a40f1b'));