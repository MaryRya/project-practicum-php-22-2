<?php

namespace Tgu\Ryabova\Blog\Repositories\UserRepository;

use PDO;
use PDOStatement;
use Tgu\Ryabova\Blog\User;
use Tgu\Ryabova\Blog\UUID;
use Tgu\Ryabova\Exceptions\UserNotFoundException;
use Tgu\Ryabova\Person\Name;

class SqliteUsersRepository implements UsersRepositoryInterface
{
    public function __construct(private PDO $connection)
    {

    }

    public function save(User $user):void{
        $statement = $this->connection->prepare(
            "INSERT INTO users (uuid, first_name, last_name, username) VALUES (:uuid,    :first_name,:last_name, :username)");
        $statement->execute([
            ':uuid'=>(string)$user->getByUuid(),
            ':first_name'=>$user->getName()->getFirstName(),
            ':last_name'=>$user->getName()->getLastName(),
            ':username'=>$user->getUserName()]);
    }

    /**
     * @throws UserNotFoundException
     */
    private function getUser(PDOStatement $statement, string $value):User{
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result===false){
            throw new UserNotFoundException("Cannot get user: $value");
        }
        return new User(new UUID($result['uuid']), new Name($result['first_name'], $result['last_name']), $result['username']);
    }

    /**
     * @throws UserNotFoundException
     */
    public function getByUsername(string $username):User
    {
        $statement = $this->connection->prepare("SELECT * FROM users WHERE username = :username");
        $statement->execute([':username'=>(string)$username]);
        return $this->getUser($statement, $username);
    }

    /**
     * @throws UserNotFoundException
     */
    public function getByUuid(UUID  $uuid): User
    {
        $statement = $this->connection->prepare("SELECT * FROM users WHERE uuid = :uuid");
        $statement->execute([':uuid'=>(string)$uuid]);
        return $this->getUser($statement, (string)$uuid);
    }
}