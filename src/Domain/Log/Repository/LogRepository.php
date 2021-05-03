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
     * @return array
     */
    public function getLogsList(): array
    {
        $sql = "SELECT log.*, device.name as 'device'
                FROM log 
                LEFT JOIN device ON device.id = log.device_id;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $Log_query = $stmt->fetchAll();

        return $Log_query;
    }


    /**
     * @param int|null $userId
     * @return array
     */
    public function getLogByUser(int $userId = null): array
    {
        $row = [
            "user_id" => $userId
        ];
        $sql = "SELECT device.name as 'device', category.name as 'category', CONCAT(log.value, ' ', category.measure), log.date 
                FROM log 
                LEFT JOIN device ON device.id = log.device_id
                LEFT JOIN category ON category.id = device.category_id
                LEFT JOIN plant ON plant.line = device.line and plant.position = device.position
                WHERE plant.created_by = :user_id;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $Log_query = $stmt->fetchAll();

        return (array)$Log_query;
    }


    /**
     * @param int|null $deviceId
     * @return array
     */
    public function getLogByDevice(int $deviceId = null): array
    {
        $row = [
            "device_id" => $deviceId
        ];
        $sql = "SELECT category.name as 'category', CONCAT(log.value, ' ', category.measure) as 'value', log.date 
                FROM log 
                LEFT JOIN device ON device.id = log.device_id
                LEFT JOIN category ON category.id = device.category_id
                WHERE log.device_id = :device_id;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $Log_query = $stmt->fetchAll();

        return $Log_query;
    }


    /**
     * @param int $line
     * @param int $position
     * @return array
     */
    public function getLogByPlant(int $line, int $position): array
    {
        $row = [
            "line" => $line,
            "position" => $position
        ];

        $sql = "SELECT  device.name as 'device', category.name as 'category', CONCAT(log.value, ' ', category.measure) as 'value', log.date 
                FROM log 
                LEFT JOIN device ON device.id = log.device_id
                LEFT JOIN category ON category.id = device.category_id
                WHERE device.line = :line and device.position = :position;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $Log_query = $stmt->fetchAll();

        return $Log_query;
    }


    /**
     * @param int $line
     * @param int $position
     * @return array
     */
    public function getLastLog(int $line, int $position): array
    {
        $row = [
            "line" => $line,
            "position" => $position
        ];
        $sql = "SELECT category.name, CONCAT(log.value, ' ', category.measure) as 'value', log.date
                FROM category
                LEFT JOIN device as device ON device.category_id = category.id and
							  device.line = :line and device.position = :position
                LEFT JOIN 
                (
                    SELECT max(id) as id, log.value as value, date, device_id
                    FROM log
                    GROUP BY device_id
                ) as log ON log.device_id = device.id;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $Log_query = $stmt->fetchAll();

        return (array)$Log_query;
    }


    /**
     * @param string $localName
     * @return int
     */
    public function getDeviceId(string $localName): int
    {
        $row = [
            "name_local" => $localName
        ];
        $sql = "SELECT id 
                FROM device
                WHERE name_local = :name_local
                LIMIT 1;";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $Log_query = $stmt->fetch();

        return (int)$Log_query['id'];
    }


    /**
     * @param array $log
     * @return int
     */
    public function insertLog(array $log): int
    {
        $row = [
            "device_id" => $this->getDeviceId($log["name_local"]),
            'value' => $log['value'],
            'date' => $log['date']
        ];

        $sql =  "INSERT INTO log SET
                    device_id = :device_id,
                    value = :value,
                    date = :date;";

        $this->connection->prepare($sql)->execute($row);

        return (int)$this->connection->lastInsertId();
    }


    /**
     * @param int $LogId
     * @return bool
     */
    public function deleteLog(int $LogId ): bool
    {
        if ($LogId) {
            $row = [
                'id' => $LogId
            ];
            $sql = "DELETE FROM log WHERE id = :id;";

        } else {
            return  (bool)false;
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($row);
        $Log_query = $stmt->fetch();

        return (bool)$Log_query;
    }
}