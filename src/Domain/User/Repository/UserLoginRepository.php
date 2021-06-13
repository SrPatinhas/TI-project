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
     * @param array $user
     * @return array
     */
    public function loginUser(array $user): array
    {
        // associated the email to the object for the sql validation
        $row = [
            'email' => $user['email']
        ];

        $stmt = $this->connection->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute($row);
        $user_query = $stmt->fetch();

        // after fetching the account, validates if exists, and if so, uses the password_verify function
        // to validate if the hash is the same, as the passwords are encrypted in the DB and not as
        // plain text
        if ($user_query && password_verify($user['password'], $user_query['password'])) {
            // if is the correct user, will return an object with all the information to create
            // the session object and prevent several requests any time that we need to get the
            // logged user information
            return (array)[
                "user" => true,
                "id" => $user_query["id"],
                "email" => $user_query["email"],
                "name" => $user_query["name"],
                "role" => $user_query["role"],
                "is_active" => $user_query["is_active"],
                "created_at" => $user_query["created_at"],
            ];
        } else {
            //returns an error message
            return (array)["user" => false, "message" => ["data" => "User not found or inputs wrong!"]];
        }
    }


    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function checkUserLogin(string $email, string $password): bool
    {
        // just validates if the user is the correct one, mostly used for the API calls
        $row = [
            'email' => $email
        ];

        $stmt = $this->connection->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute($row);
        $user_query = $stmt->fetch();

        if ($user_query && password_verify($password, $user_query['password'])) {
           return true;
        } else {
            return false;
        }
    }


}