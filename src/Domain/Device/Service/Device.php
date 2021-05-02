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

namespace App\Domain\Device\Service;

use App\Domain\Device\Repository\DeviceRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class Device
{
    /**
     * @var DeviceRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param DeviceRepository $repository The repository
     */
    public function __construct(DeviceRepository $repository)
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
    public function getDevice(int $plantId = null, string $name = null): array
    {
        if ($plantId == null && $name == null) {
            return [];
        }
        // Insert user
        return $this->repository->getDevice($plantId, $name);
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
        $plantId = $this->repository->insertDevice($plant);

        $result = [
            'id' => $plantId
        ];
        // Logging here: Device created successfully
        //$this->logger->info(sprintf('Device created successfully: %s', $plantId));
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
        $plantId = $this->repository->updateDevice($plant);

        $result = [
            'id' => $plantId
        ];
        // Logging here: Device created successfully
        //$this->logger->info(sprintf('Device created successfully: %s', $plantId));
        return $result;
    }

    /**
     * @param int $plantId
     * @return bool
     */
    public function deleteDevice(int $plantId ): bool
    {
        if (!$plantId) {
            return (bool)false;
        }
        return $this->repository->deleteDevice($plantId);
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

        if (empty($data['location'])) {
            $errors['location'] = 'Location required';
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