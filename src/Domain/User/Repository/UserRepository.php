<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 6:05 PM
 *
 * File: UserCreatorRepository.php
 */

namespace App\Domain\User\Repository;

use PDO;

/**
 * Repository.
 */
class UserRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }


    /**
     *  Get users list
     *
     * @return array
     */
    public function getUsersList(): array
    {
        $sql = "SELECT * FROM user;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $user_query = $stmt->fetchAll();

        return $user_query;
    }


    /**
     *  Get user by fields
     *
     * @param int|null $userId
     * @param string|null $email
     *
     * @return array
     */
    public function getUser(int $userId = null, string $email = null): array
    {
        if ($userId) {
            $row = [
                'id' => $userId
            ];
            $sql = "SELECT * FROM user WHERE id = :id;";
        } else if ($email) {
            $row = [
                'email' => $email
            ];
            $sql = "SELECT * FROM user WHERE email = :email;";
        } else {
            return  [];
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $user_query = $stmt->fetch();

        return (array)$user_query;
    }

    /**
     * Insert user row.
     *
     * @param array $user The user
     *
     * @return int The new ID
     */
    public function insertUser(array $user): int
    {
        $row = [
            'email' => $user['email'],
            'password' => password_hash($user['password'], PASSWORD_DEFAULT),
            'name' => $user['name'],
            'role' => $user['role']
        ];

        $sql =  "INSERT INTO user SET " .
                " email=:email, " .
                " name=:name, " .
                " role=:role, " .
                " password=:password;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    /**
     * Insert user row.
     *
     * @param array $user The user
     *
     * @return int The new ID
     */
    public function updateUser(array $user): int
    {
        $row = [
            'id' => $user['id'],
            'email' => $user['email'],
            'password' => password_hash($user['password'], PASSWORD_DEFAULT),
            'name' => $user['name'],
            'role' => $user['role']
        ];

        $sql =  "UPDATE user SET
                email = :email, 
                name = :name, 
                role = :role, 
                password = :password
                WHERE id = :id;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }


    public function deleteUser(int $userId ): bool
    {
        if ($userId) {
            $row = [
                'id' => $userId
            ];
            $sql = "DELETE FROM user WHERE id = :id;";

        } else {
            return  (bool)false;
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $user_query = $stmt->fetch();

        return (bool)$user_query;
    }
}