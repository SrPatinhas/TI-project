<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 5:46 PM
 *
 * File: LogCreator.php
 */

namespace App\Domain\Log\Service;

use App\Domain\Log\Repository\LogRepository;
use App\Exception\ValidationException;

/**
 * Service.
 */
final class Log
{
    /**
     * @var LogRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param LogRepository $repository The repository
     */
    public function __construct(LogRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getLogsList(): array
    {
        // gets a list of logs from the function
        return $this->repository->getLogsList();
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getLogByUser(int $userId): array
    {
        // gets a list of logs for a specific user, based on its plants and location of those
        return $this->repository->getLogByUser($userId);
    }

    /**
     * @param int $deviceId
     * @return array
     */
    public function getLogByDevice(int $deviceId, bool $onlyValues = false): array
    {
        // get all the logs by a single device
        return $this->repository->getLogByDevice($deviceId, $onlyValues);
    }

    /**
     * @param int $line
     * @param int $position
     * @return array
     */
    public function getLogByPlant(int $line, int $position, bool $onlyValues = false): array
    {
        // get a list of logs from a specific position, where the given plant is
        return $this->repository->getLogByPlant($line, $position, $onlyValues);
    }

    /**
     * @param int $line
     * @param int $position
     * @return array
     */
    public function getLastLog(int $line, int $position): array
    {
        // get the last log in the given position for every category
        return $this->repository->getLastLog($line, $position);
    }

    /**
     * @param int $line
     * @param int $position
     * @return array
     */
    public function getLastLogByDeviceId(int $deviceId): array
    {
        // get the last log from a single device
        return $this->repository->getLastLogByDeviceId($deviceId);
    }

    /**
     * @param int $line
     * @param int $position
     * @return array
     */
    public function getLastLogByCategory(int $line, int $position, int $category): array
    {
        // get the last log for the given category
        return $this->repository->getLastLogByCategory($line, $position, $category);
    }

    /**
     * @param array $log
     * @return array
     */
    public function createLog(array $log): array
    {
        // Insert a new log
        $logId = $this->repository->insertLog($log);

        $result = [
            'id' => $logId
        ];
        // Logging here: Log created successfully
        //$this->logger->info(sprintf('Log created successfully: %s', $logId));
        return $result;
    }

}