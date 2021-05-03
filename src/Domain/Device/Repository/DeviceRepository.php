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
     * @param int|null $deviceId
     * @param string|null $name
     * @return array
     */
    public function getDevice(int $deviceId = null, string $name = null): array
    {
        if ($deviceId) {
            $row = [
                'id' => $deviceId
            ];
            $sql = "SELECT device.*, category.measure FROM device LEFT JOIN category ON category.id = device.category_id WHERE device.id = :id;";
        } else if ($name) {
            $row = [
                'name' => $name
            ];
            $sql = "SELECT device.*, category.measure FROM device LEFT JOIN category ON category.id = device.category_id WHERE device.name = :name;";
        } else {
            return  [];
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $device_query = $stmt->fetch();

        return (array)$device_query;
    }

    /**
     * @return array
     */
    public function getCategoriesList(): array
    {
        $sql = "SELECT id, name FROM category ORDER BY name ASC;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $device_query = $stmt->fetchAll();

        return $device_query;
    }

    /**
     * @param $id
     * @param $local_name
     * @return bool
     */
    public function checkDeviceName($id, $local_name): bool
    {
        if ($id) {
            $row = [
                'id' => $id,
                'local_name' => $local_name
            ];
            $sql = "SELECT * FROM device WHERE id <> :id and name_local = :local_name;";
        } else {
            $row = [
                'local_name' => $local_name
            ];
            $sql = "SELECT * FROM device WHERE name_local = :local_name;";
        }
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $device_query = $stmt->fetchAll();

        return count($device_query) > 0;
    }


    /**
     * @param array $device
     * @return int
     */
    public function insertDevice(array $device): int
    {
        $row = [
            'category_id' => $device['category_id'],
            'name_local' => $device['name_local'],
            'name' => $device['name'],
            'description' => $device['description'],
            'line' => $device['line'],
            'position' => $device['position'],
            'type' => $device['type'],
            'switch_value' => $device['switch_value'],
            'force_on' => ($device['force_on'] ? 1 : 0),
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
                    switch_value = :switch_value,
                    force_on = :force_on,
                    is_active = :is_active;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    /**
     * @param array $device
     * @return int
     */
    public function updateDevice(array $device): int
    {
        $row = [
            'category_id' => $device['category_id'],
            'name_local' => $device['name_local'],
            'name' => $device['name'],
            'description' => $device['description'],
            'line' => $device['line'],
            'position' => $device['position'],
            'type' => $device['type'],
            'switch_value' => $device['switch_value'],
            'force_on' => ($device['force_on'] ? 1 : 0),
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
                    switch_value = :switch_value,
                    force_on = :force_on,
                    is_active = :is_active
                    WHERE id = :id;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$device['id'];
    }


    /**
     * @param int $deviceId
     * @return bool
     */
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