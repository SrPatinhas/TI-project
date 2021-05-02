<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 6:05 PM
 *
 * File: DeviceCreatorRepository.php
 */

namespace App\Domain\Device\Repository;

use PDO;

/**
 * Repository.
 */
class DeviceRepository
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
    public function getDevicesList(): array
    {
        $sql = "SELECT device.*, category.name as 'category' FROM device LEFT JOIN category ON category.id = device.category_id;";

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
    public function getDevice(int $deviceId = null, string $name = null): array
    {
        if ($deviceId) {
            $row = [
                'id' => $deviceId
            ];
            $sql = "SELECT * FROM device WHERE id = :id;";
        } else if ($name) {
            $row = [
                'name' => $name
            ];
            $sql = "SELECT * FROM device WHERE name = :name;";
        } else {
            return  [];
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $device_query = $stmt->fetch();

        return (array)$device_query;
    }

    /**
     * Insert user row.
     *
     * @param array $user The user
     *
     * @return int The new ID
     */
    public function insertDevice(array $user): int
    {
        $row = [
            'name' => $user['name'],
            'location' => $user['location'],
            'cover' => $user['cover'],
            'webcam' => $user['webcam'],
            'is_active' => ($user['is_active'] ? 1 : 0),
            'created_by' => $user['created_by']
        ];

        $sql =  "INSERT INTO device SET
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
    public function updateDevice(array $user): int
    {
        $row = [
            'name' => $user['name'],
            'location' => $user['location'],
            'cover' => $user['cover'],
            'webcam' => $user['webcam'],
            'is_active' => $user['is_active'],
            'created_by' => $user['created_by']
        ];

        $sql =  "UPDATE device SET
                    name = :name,
                    location = :location,
                    cover = :cover,
                    webcam = :webcam,
                    is_active = :is_active
                    WHERE id = :id;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }


    public function deleteDevice(int $deviceId ): bool
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