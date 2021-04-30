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
     *  Get users list
     *
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
     *  Get user by fields
     *
     * @param int|null $plantId
     * @param string|null $name
     *
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
     * Insert user row.
     *
     * @param array $user The user
     *
     * @return int The new ID
     */
    public function insertPlant(array $user): int
    {
        $row = [
            'name' => $user['name'],
            'location' => $user['location'],
            'cover' => $user['cover'],
            'webcam' => $user['webcam'],
            'is_active' => ($user['is_active'] ? 1 : 0),
            'created_by' => $user['created_by']
        ];

        $sql =  "INSERT INTO plant SET
                    name = :name,
                    location = :location,
                    cover = :cover,
                    webcam = :webcam,
                    is_active = :is_active,
                    created_by = :created_by;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    /**
     * Insert user row.
     *
     * @param array $user The user
     *
     * @return int The new ID
     */
    public function updatePlant(array $user): int
    {
        $row = [
            'name' => $user['name'],
            'location' => $user['location'],
            'cover' => $user['cover'],
            'webcam' => $user['webcam'],
            'is_active' => $user['is_active'],
            'created_by' => $user['created_by']
        ];

        $sql =  "UPDATE plant SET
                    name = :name,
                    location = :location,
                    cover = :cover,
                    webcam = :webcam,
                    is_active = :is_active
                    WHERE id = :id;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }


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