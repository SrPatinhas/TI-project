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
     * @return array
     */
    public function getDevicesList(): array
    {
        // gets a list of devices from the function
        return $this->repository->getDevicesList();
    }

    /**
     * @return array
     */
    public function getDevicesListByType(string $type): array
    {
        // gets a list of devices, based on a type of device
        return $this->repository->getDevicesListByType($type);
    }

    /**
     * @param int|null $deviceId
     * @param string|null $name
     * @return array
     */
    public function getDevice(int $deviceId = null, string $name = null): array
    {
        if ($deviceId == null && $name == null) {
            return [];
        }
        // gets a device information, based on a device ID or name
        return $this->repository->getDevice($deviceId, $name);
    }

    /**
     * @param int|null $deviceId
     * @param string|null $name
     * @return array
     */
    public function getDeviceInfo(int $deviceId = null, string $name = null, string $local_name = null): array
    {
        if ($deviceId == null && $name == null && $local_name == null) {
            return [];
        }
        // gets a device information, based on a device ID or name or local name
        return $this->repository->getDeviceInfo($deviceId, $name, $local_name);
    }


    /**
     * @return array
     */
    public function getCategoriesList(): array
    {
        // gets a list of categories saved in the DB
        return $this->repository->getCategoriesList();
    }

    /**
     * @param array $device
     * @return array
     */
    public function createDevice(array $device): array
    {
        // Input validation for a new device
        $checkData = $this->validateNewDevice($device);
        // if any error, will return a list of errors
        if ($checkData) {
            return $checkData;
        }
        // Insert a new device
        $deviceId = $this->repository->insertDevice($device);
        // returns a ID of the new device
        $result = [
            'id' => $deviceId
        ];
        // Logging here: Device created successfully
        //$this->logger->info(sprintf('Device created successfully: %s', $deviceId));
        return $result;
    }

    /**
     * @param array $device
     * @return array
     */
    public function updateDevice(array $device): array
    {
        // Input validation for the device
        $checkData = $this->validateNewDevice($device);
        // if any error, will return a list of errors
        if ($checkData) {
            return $checkData;
        }
        // Update a given device
        $deviceId = $this->repository->updateDevice($device);
        // returns a ID of the new device
        $result = [
            'id' => $deviceId
        ];
        return $result;
    }

    /**
     * @param array $device
     * @return array
     */
    public function updateDeviceField(array $device): array
    {
        // updated a single field of a device
        $deviceId = $this->repository->updateDeviceField($device);
        // returns a ID of the new device
        $result = [
            'id' => $deviceId
        ];
        return $result;
    }



    /**
     * @param int $deviceId
     * @return bool
     */
    public function deleteDevice(int $deviceId ): bool
    {
        // validates if the device ID exists
        if (!$deviceId) {
            return (bool)false;
        }
        //requests for the device to be deleted
        return $this->repository->deleteDevice($deviceId);
    }


    /**
     * Input validation.
     *
     * @param array $data The form data
     *
     * @return array of errors
     */
    private function validateNewDevice(array $data): array
    {
        $errors = [];
        // validates several fields and returns the appropriated error message
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
        return $errors;
    }
}