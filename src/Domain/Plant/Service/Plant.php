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
        // gets a list of all the plants
        return $this->repository->getPlantsList();
    }


    /**
     * @param int $userId
     * @return array
     */
    public function getPlantsListByUser(int $userId): array
    {
        // gets a list of plants owned by a specific user
        return $this->repository->getPlantsListByUser($userId);
    }

    /**
     * @return array
     */
    public function getWebcamsList(): array
    {
        // gets a list of all the webcams saved in the plants information
        return $this->repository->getPlantsList();
    }


    /**
     * @param int|null $plantId
     * @param string|null $name
     * @return array
     */
    public function getPlant(int $plantId = null, string $name = null): array
    {
        // validated if the filters have data
        if ($plantId == null && $name == null) {
            return [];
        }
        // returns a specific plant, based on the params given
        return $this->repository->getPlant($plantId, $name);
    }


    /**
     * @param array $plant
     * @return array
     */
    public function createPlant(array $plant): array
    {
        // Input validation for a new plant
        $checkData = $this->validateNewPlant($plant);
        // if any error, will return a list of errors
        if ($checkData) {
            return $checkData;
        }
        // Insert a new plant
        $plantId = $this->repository->insertPlant($plant);
        // returns a ID of the new plant
        $result = [
            'id' => $plantId
        ];
        return $result;
    }

    /**
     * @param array $plant
     * @return array
     */
    public function updatePlant(array $plant): array
    {
        // Input validation for a given plant
        $checkData = $this->validateNewPlant($plant);
        // if any error, will return a list of errors
        if ($checkData) {
            return $checkData;
        }
        // update a given plant
        $plantId = $this->repository->updatePlant($plant);
        // returns a ID of the updated plant
        $result = [
            'id' => $plantId
        ];
        return $result;
    }

    /**
     * @param int $plantId
     * @return bool
     */
    public function deletePlant(int $plantId ): bool
    {
        // validates if the plant ID exists
        if (!$plantId) {
            return (bool)false;
        }
        //requests for the plant to be deleted
        return $this->repository->deletePlant($plantId);
    }

    /**
     * @param array $data
     * @return array
     */
    private function validateNewPlant(array $data): array
    {
        $errors = [];
        // validates several fields and returns the appropriated error message
        if (empty($data['line'])) {
            $errors['line'] = 'Line required';
        }
        if (empty($data['position'])) {
            $errors['position'] = 'Position required';
        }
        if (empty($data['name'])) {
            $errors['name'] = 'Name required';
        }
        return $errors;
    }
}