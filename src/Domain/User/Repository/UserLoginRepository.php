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
class UserLoginRepository
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
     * Insert user row.
     *
     * @param array $user The user
     *
     * @return bool with the response if it has login or not
     */
    public function loginUser(array $user): array
    {
        $row = [
            'email' => $user['email']
        ];

        $stmt = $this->connection->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute($row);
        $user_query = $stmt->fetch();


        if ($user_query && password_verify($user['password'], $user_query['password'])) {
            return (array)[
                "user" => true,
                "email" => $user_query["email"],
                "name" => $user_query["name"],
                "role" => $user_query["role"],
                "is_active" => $user_query["is_active"],
                "created_at" => $user_query["created_at"],
            ];
        } else {
            return (array)["user" => false, "message" => ["data" => "User not found or inputs wrong!"]];
        }


    }
}