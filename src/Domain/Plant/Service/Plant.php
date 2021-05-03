<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 5:46 PM
 *
 * File: PlantCreator.php
 */

namespace App\Domain\Plant\Service;

use App\Domain\Plant\Repository\PlantRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class Plant
{
    /**
     * @var PlantRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param PlantRepository $repository The repository
     */
    public function __construct(PlantRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @return array
     */
    public function getPlantsList(): array
    {
        // Insert user
        return $this->repository->getPlantsList();
    }


    /**
     * @param int $userId
     * @return array
     */
    public function getPlantsListByUser(int $userId): array
    {
        // Insert user
        return $this->repository->getPlantsListByUser($userId);
    }

    /**
     * @return array
     */
    public function getWebcamsList(): array
    {
        // Insert user
        return $this->repository->getPlantsList();
    }


    /**
     * @param int|null $plantId
     * @param string|null $name
     * @return array
     */
    public function getPlant(int $plantId = null, string $name = null): array
    {
        if ($plantId == null && $name == null) {
            return [];
        }
        // Insert user
        return $this->repository->getPlant($plantId, $name);
    }


    /**
     * @param array $plant
     * @return array
     */
    public function createPlant(array $plant): array
    {
        // Input validation
        $checkData = $this->validateNewPlant($plant);

        if ($checkData) {
            return $checkData;
        }

        // Insert user
        $plantId = $this->repository->insertPlant($plant);

        $result = [
            'id' => $plantId
        ];
        // Logging here: Plant created successfully
        //$this->logger->info(sprintf('Plant created successfully: %s', $plantId));
        return $result;
    }

    /**
     * @param array $plant
     * @return array
     */
    public function updatePlant(array $plant): array
    {
        // Input validation
        $checkData = $this->validateNewPlant($plant);

        if ($checkData) {
            return $checkData;
        }

        // Insert user
        $plantId = $this->repository->updatePlant($plant);

        $result = [
            'id' => $plantId
        ];
        // Logging here: Plant created successfully
        //$this->logger->info(sprintf('Plant created successfully: %s', $plantId));
        return $result;
    }

    /**
     * @param int $plantId
     * @return bool
     */
    public function deletePlant(int $plantId ): bool
    {
        if (!$plantId) {
            return (bool)false;
        }
        return $this->repository->deletePlant($plantId);
    }


    /**
     * @param array $data
     * @return array
     */
    private function validateNewPlant(array $data): array
    {
        $errors = [];

        // Here you can also use your preferred validation library

        if (empty($data['line'])) {
            $errors['line'] = 'Line required';
        }
        if (empty($data['position'])) {
            $errors['position'] = 'Position required';
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