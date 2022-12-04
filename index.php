<?php

require_once __DIR__ . '/vendor/autoload.php';
//
//use Tgu\Ryabova\Blog\Post;
//use Tgu\Ryabova\Person\Name;
//use Tgu\Ryabova\Person\Person;
//use Tgu\Ryabova\Blog\Comment;
//
//spl_autoload_register(function ($class){
//    $file = str_replace("/",DIRECTORY_SEPARATOR, $class). '.php';
//    $file[strrpos($file, '_')] = '\\';
//    echo $file;
//if (file_exists($file)){
//    require $file;
//}
//});
//
//$post = new Post(
//    new Person(
//        new Name(1, 'Иван', 'Иванов'),
//
//    ),
//    'Привет!', 2, 1, ''
//);
//
//$comment = new Comment(
//    1, 1, 2, ''
//);
//
//print $post;

function someFunction(bool $one, int $two=42,):string
{
    return $one . $two;
}

$reflection = new ReflectionFunction('someFunction');
echo $reflection->getReturnType()->getName()."\n";
foreach ($reflection->getParameters() as $parameter){
    echo $parameter->getName().'['.$parameter->getType()->getName()."]\n";
}