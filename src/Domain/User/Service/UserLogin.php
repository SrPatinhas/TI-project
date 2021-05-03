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

use App\Domain\User\Repository\UserLoginRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class UserLogin
{
    /**
     * @var UserLoginRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param UserLoginRepository $repository The repository
     */
    public function __construct(UserLoginRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function loginUser(array $data): array
    {
        // Input validation
        $errors = $this->validateLoginUser($data);

        if (!empty($errors)) {
            return [
                "user" => false,
                "message" => $errors
            ];
        }
        // Logging here: User created successfully
        //$this->logger->info(sprintf('User logged in successfully: %s', $userId));

        // Validates if user has account
        return $this->repository->loginUser($data);
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function checkUserLogin(string $email, string $password): bool
    {
       if(empty($email) || empty($password)) {
           return false;
       }
        // Validates if user has account
        return $this->repository->checkUserLogin($email, $password);
    }

    /**
     * @param array $data
     * @return array
     */
    private function validateLoginUser(array $data): array
    {
        $errors = [];

        if (empty($data['email'])) {
            $errors['email'] = 'Input required';
        } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'Invalid email address';
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Password required';
        }

        if ($errors) {
            return (array)$errors;
        }
        return (array)[];
    }
}