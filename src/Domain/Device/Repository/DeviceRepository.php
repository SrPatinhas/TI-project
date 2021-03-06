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
     * this will return a list of all the devices saved in the BD
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
     * @return array
     * returns a list of devices filtered by the type
     */
    public function getDevicesListByType(string $type = null): array
    {
        $row = [
            'type' => $type
        ];
        $sql = "SELECT device.*, category.name as 'category' FROM device LEFT JOIN category ON category.id = device.category_id WHERE device.type = :type;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $device_query = $stmt->fetchAll();

        return $device_query;
    }

    /**
     * @param int|null $deviceId
     * @param string|null $name
     * @return array
     *
     * returns a single device, based in the id or the name
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
     * @param int|null $deviceId
     * @param string|null $name
     * @return array
     *
     * returns all the info, based in the device id, name or local_name
     */
    public function getDeviceInfo(int $deviceId = null, string $name = null, string $local_name = null): array
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
        } else if ($local_name) {
            $row = [
                'name' => $local_name
            ];
            $sql = "SELECT device.*, category.measure FROM device LEFT JOIN category ON category.id = device.category_id WHERE device.name_local = :name;";
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
     *
     * get a list of all the categories saved in the DB, order by the name
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
     *
     * get all the data from a device based on the local name and ID or just local name
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
     *
     * insert a new device, with all the information given in a previous function
     * and returns the ID
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
            'device_bridge_id' => $device['device_bridge_id'],
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
                    device_bridge_id = :device_bridge_id,
                    is_active = :is_active;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }

    /**
     * @param array $device
     * @return int
     *
     * updates a device with new information, filtered by the ID and returns the ID
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
            'device_bridge_id' => $device['device_bridge_id'],
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
                    device_bridge_id = :device_bridge_id,
                    is_active = :is_active
                    WHERE id = :id;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$device['id'];
    }

    /**
     * @param array $device
     * @return int
     *
     * update a single field of the device, validated previously
     */
    public function updateDeviceField(array $device): int
    {
        $row = [
            'value' => ($device['value'] ? 1 : 0),
            'id' => $device['id']
        ];

        $sql =  "UPDATE device SET " . $device['field'] . " = :value WHERE id = :id;";

        $this->connection->prepare($sql)->execute($row);
        return (int)$device['id'];
    }


    /**
     * @param int $deviceId
     * @return bool
     *
     * deletes a device from a given device ID
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