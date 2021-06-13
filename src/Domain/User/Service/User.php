<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 5:46 PM
 *
 * File: UserCreator.php
 */

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class User
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserRepository $repository The repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get users list
     *
     * @return array of users list
     */
    public function getUsersList(): array
    {
        // gets a list of all the users
        return $this->repository->getUsersList();
    }

    /**
     * get a user by ID.
     *
     * @param array $data The form data
     *
     * @return array of user
     */
    public function getUser(int $userId = null, string $email = null): array
    {
        // validates if the userId or email was passed by
        if ($userId == null && $email == null) {
            return [];
        }
        // returns an array of the requested user
        return $this->repository->getUser($userId, $email);
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return array of new user
     */
    public function createUser(array $data): array
    {
        // Input validation for the user
        $checkData = $this->validateNewUser($data);
        // if any error, will return a list of errors
        if ($checkData) {
            return $checkData;
        }
        // Insert a new user
        $userId = $this->repository->insertUser($data);
        // returns a ID of the new user
        $result = [
            'id' => $userId
        ];
        return $result;
    }

    /**
     * @param array $user
     * @return array of user
     */
    public function updateUser(array $user): array
    {
        // Input validation for the user
        $checkData = $this->validateNewUser($user);
        // if any error, will return a list of errors
        if ($checkData) {
            return $checkData;
        }
        // Update a given user
        $userId = $this->repository->updateUser($user);
        // returns a ID of the given user
        $result = [
            'id' => $userId
        ];
        return $result;
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId ): bool
    {
        // validates if the user ID exists
        if (!$userId) {
            return (bool)false;
        }
        //requests for the user to be deleted
        return $this->repository->deleteUser($userId);
    }


    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @throws ValidationException
     *
     * @return void
     */
    private function validateNewUser(array $data): array
    {
        $errors = [];
        // validates several fields and returns the appropriated error message
        if (empty($data["id"])) {
            if (empty($data['password'])) {
                $errors['password'] = 'Password required';
            }
        }
        if (empty($data['role'])) {
            $errors['role'] = 'Role required';
        }
        if (empty($data['email'])) {
            $errors['email'] = 'Input required';
        } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'Invalid email address';
        }
        return $errors;
    }
}