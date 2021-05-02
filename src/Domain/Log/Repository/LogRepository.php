<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 6:05 PM
 *
 * File: LogCreatorRepository.php
 */

namespace App\Domain\Log\Repository;

use PDO;

/**
 * Repository.
 */
class LogRepository
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
    public function getLogsList(): array
    {
        $sql = "SELECT log.*, device.name as 'device', plant.name as 'plant' 
                FROM log 
                LEFT JOIN device ON device.id = log.device_id
                LEFT JOIN plant ON plant.id = log.plant_id;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $device_query = $stmt->fetchAll();

        return $device_query;
    }


    /**
     *  Get user by fields
     *
     * @param int|null $deviceId
     * @param string|null $name
     *
     * @return array
     */
    public function getLogByUser(int $userId = null): array
    {
        $row = [
            "user_id" => $userId
        ];
        $sql = "SELECT log.*, device.name as 'device', plant.name as 'plant' 
                FROM log 
                LEFT JOIN device ON device.id = log.device_id
                LEFT JOIN plant ON plant.id = log.plant_id
                WHERE plant.created_by = :user_id;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $device_query = $stmt->fetch();

        return (array)$device_query;
    }


    /**
     *  Get user by fields
     *
     * @param int|null $deviceId
     * @param string|null $name
     *
     * @return array
     */
    public function getLogByDevice(int $deviceId = null): array
    {
        $row = [
            "device_id" => $deviceId
        ];
        $sql = "SELECT log.*, device.name as 'device', plant.name as 'plant' 
                FROM log 
                LEFT JOIN device ON device.id = log.device_id
                LEFT JOIN plant ON plant.id = log.plant_id
                WHERE log.device_id = :device_id;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $device_query = $stmt->fetch();

        return (array)$device_query;
    }



    /**
     * Insert user row.
     *
     * @param array $device The user
     *
     * @return int The new ID
     */
    public function insertLog(array $device): int
    {
        $row = [
            'category_id' => $device['category_id'],
            'name_local' => $device['name_local'],
            'name' => $device['name'],
            'description' => $device['description'],
            'line' => $device['line'],
            'position' => $device['position'],
            'type' => $device['type'],
            'is_active' => ($device['is_active'] ? 1 : 0)
        ];

        $sql =  "INSERT INTO device SET
                    category_id = :category_id,
                    name_local = :name_local,
                    name = :name,
                    description = :description,
                    line = :line,
                    position = :position,
                    type = :type,
                    is_active = :is_active;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    /**
     * Insert user row.
     *
     * @param array $device The user
     *
     * @return int The new ID
     */
    public function updateLog(array $device): int
    {
        $row = [
            'category_id' => $device['category_id'],
            'name_local' => $device['name_local'],
            'name' => $device['name'],
            'description' => $device['description'],
            'line' => $device['line'],
            'position' => $device['position'],
            'type' => $device['type'],
            'is_active' => ($device['is_active'] ? 1 : 0),
            'id' => $device['id']
        ];

        $sql =  "UPDATE device SET
                    category_id = :category_id,
                    name_local = :name_local,
                    name = :name,
                    description = :description,
                    line = :line,
                    position = :position,
                    type = :type,
                    is_active = :is_active
                    WHERE id = :id;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$device['id'];
    }


    public function deleteLog(int $deviceId ): bool
    {
        if ($deviceId) {
            $row = [
                'id' => $deviceId
            ];
            $sql = "DELETE FROM device WHERE id = :id;";

        } else {
            return  (bool)false;
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $device_query = $stmt->fetch();

        return (bool)$device_query;
    }
}