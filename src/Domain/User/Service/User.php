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
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function getUsersList(): array
    {
        // Insert user
        return $this->repository->getUsersList();
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function getUser(int $userId = null, string $email = null): array
    {
        if ($userId == null && $email == null) {
            return [];
        }
        // Insert user
        return $this->repository->getUser($userId, $email);
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function createUser(array $data): int
    {
        // Input validation
        $this->validateNewUser($data);

        // Insert user
        $userId = $this->repository->insertUser($data);
        // Logging here: User created successfully
        //$this->logger->info(sprintf('User created successfully: %s', $userId));
        return $userId;
    }

    /**
     * @param array $user
     * @return int
     */
    public function updateUser(array $user): int
    {
        // Input validation
        $this->validateNewUser($user);

        // Insert user
        $userId = $this->repository->updateUser($user);
        // Logging here: User created successfully
        //$this->logger->info(sprintf('User created successfully: %s', $userId));
        return $userId;
    }

    /**
     * @param int $userId
     * @return bool
     */
    public function deleteUser(int $userId ): bool
    {
        if (!$userId) {
            return (bool)false;
        }
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
    private function validateNewUser(array $data): void
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['password'])) {
            $errors['password'] = 'Password required';
        }
        if (empty($data['role'])) {
            $errors['role'] = 'Role required';
        }
        if (empty($data['email'])) {
            $errors['email'] = 'Input required';
        } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'Invalid email address';
        }

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}