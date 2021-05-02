<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 5:46 PM
 *
 * File: DeviceCreator.php
 */

namespace App\Domain\Log\Service;

use App\Domain\Log\Repository\LogRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class Log
{
    /**
     * @var LogRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param LogRepository $repository The repository
     */
    public function __construct(LogRepository $repository)
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
    public function getDevicesList(): array
    {
        // Insert user
        return $this->repository->getDevicesList();
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function getDevice(int $deviceId = null, string $name = null): array
    {
        if ($deviceId == null && $name == null) {
            return [];
        }
        // Insert user
        return $this->repository->getDevice($deviceId, $name);
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function getCategoriesList(): array
    {
        // Insert user
        return $this->repository->getCategoriesList();
    }
    /**
     * Create a new user.
     *
     * @param array $plant The form data
     *
     * @return int The new user ID
     */
    public function createDevice(array $plant): array
    {
        // Input validation
        $checkData = $this->validateNewDevice($plant);

        if ($checkData) {
            return $checkData;
        }

        // Insert user
        $deviceId = $this->repository->insertDevice($plant);

        $result = [
            'id' => $deviceId
        ];
        // Logging here: Device created successfully
        //$this->logger->info(sprintf('Device created successfully: %s', $deviceId));
        return $result;
    }

    /**
     * @param array $plant
     * @return int
     */
    public function updateDevice(array $plant): array
    {
        // Input validation
        $checkData = $this->validateNewDevice($plant);

        if ($checkData) {
            return $checkData;
        }

        // Insert user
        $deviceId = $this->repository->updateDevice($plant);

        $result = [
            'id' => $deviceId
        ];
        // Logging here: Device created successfully
        //$this->logger->info(sprintf('Device created successfully: %s', $deviceId));
        return $result;
    }

    /**
     * @param int $deviceId
     * @return bool
     */
    public function deleteDevice(int $deviceId ): bool
    {
        if (!$deviceId) {
            return (bool)false;
        }
        return $this->repository->deleteDevice($deviceId);
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
    private function validateNewDevice(array $data): array
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['name_local'])) {
            $errors['name_local'] = 'Local Name required';
        } else {
            $nameCheck = $this->repository->checkDeviceName($data['id'], $data['name_local']);
            if ($nameCheck) {
                $errors['name_local'] = 'Local Name already exists, try another name';
            }
        }
        if (empty($data['line'])) {
            $errors['line'] = 'Line required';
        }
        if (empty($data['position'])) {
            $errors['position'] = 'Position required';
        }
        if (empty($data['category_id'])) {
            $errors['category_id'] = 'Category required';
        }
        if (empty($data['type'])) {
            $errors['type'] = 'Type required';
        }
        if (empty($data['name'])) {
            $errors['name'] = 'Name required';
        }

        /*if ($errors) {
            //throw new ValidationException('Please check your input', $errors);
        }*/
        return $errors;
    }
}