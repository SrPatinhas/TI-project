<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 6:05 PM
 *
 * File: PlantCreatorRepository.php
 */

namespace App\Domain\Plant\Repository;

use PDO;

/**
 * Repository.
 */
class PlantRepository
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
     * @return array
     */
    public function getPlantsList(): array
    {
        $sql = "SELECT * FROM plant;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $plant_query = $stmt->fetchAll();

        return $plant_query;
    }


    /**
     * @param int $userId
     * @return array
     */
    public function getPlantsListByUser(int $userId): array
    {
        $row = [
            'created_by' => $userId
        ];
        $sql = "SELECT * FROM plant WHERE created_by = :created_by;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $plant_query = $stmt->fetchAll();

        return $plant_query;
    }


    /**
     * @param int|null $plantId
     * @param string|null $name
     * @return array
     */
    public function getPlant(int $plantId = null, string $name = null): array
    {
        if ($plantId) {
            $row = [
                'id' => $plantId
            ];
            $sql = "SELECT * FROM plant WHERE id = :id;";
        } else if ($name) {
            $row = [
                'name' => $name
            ];
            $sql = "SELECT * FROM plant WHERE name = :name;";
        } else {
            return  [];
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $plant_query = $stmt->fetch();

        return (array)$plant_query;
    }


    /**
     * @return array
     */
    public function getWebcamsList(): array
    {
        $sql = "SELECT name, line, position, webcam FROM plant WHERE webcam <> '' GROUP BY webcam;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $plant_query = $stmt->fetchAll();

        return $plant_query;
    }


    /**
     * @param array $plant
     * @return int
     */
    public function insertPlant(array $plant): int
    {
        $row = [
            'name' => $plant['name'],
            'line' => $plant['line'],
            'position' => $plant['position'],
            'cover' => $plant['cover'],
            'webcam' => $plant['webcam'],
            'is_active' => ($plant['is_active'] ? 1 : 0),
            'created_by' => $plant['created_by']
        ];

        $sql =  "INSERT INTO plant SET
                    name = :name,
                    line = :line,
                    position = :position,
                    cover = :cover,
                    webcam = :webcam,
                    is_active = :is_active,
                    created_by = :created_by;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    /**
     * @param array $plant
     * @return int
     */
    public function updatePlant(array $plant): int
    {
        $row = [
            'name' => $plant['name'],
            'line' => $plant['line'],
            'position' => $plant['position'],
            'cover' => $plant['cover'],
            'webcam' => $plant['webcam'],
            'is_active' => ($plant['is_active'] ? 1 : 0),
            'id' => $plant['id']
        ];

        $sql =  "UPDATE plant SET
                    name = :name,
                    line = :line,
                    position = :position,
                    cover = :cover,
                    webcam = :webcam,
                    is_active = :is_active
                    WHERE id = :id;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$plant['id'];
    }


    /**
     * @param int $plantId
     * @return bool
     */
    public function deletePlant(int $plantId ): bool
    {
        if ($plantId) {
            $row = [
                'id' => $plantId
            ];
            $sql = "DELETE FROM plant WHERE id = :id;";

        } else {
            return  (bool)false;
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $plant_query = $stmt->fetch();

        return (bool)$plant_query;
    }
}