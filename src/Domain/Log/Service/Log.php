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
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function getLogsList(): array
    {
        // Insert user
        return $this->repository->getLogsList();
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function getLogByUser(int $userId): array
    {
        // Insert user
        return $this->repository->getLogByUser($userId);
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function getLogByDevice(int $deviceId): array
    {
        // Insert user
        return $this->repository->getLogByDevice($deviceId);
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function getLogByPlant(int $line, int $position): array
    {
        // Insert user
        return $this->repository->getLogByPlant($line, $position);
    }

    /**
     * Create a new user.
     *
     * @param array $data The form data
     *
     * @return int The new user ID
     */
    public function getLastLog(int $line, int $position): array
    {
        // Insert user
        return $this->repository->getLastLog($line, $position);
    }

    /**
     * Create a new user.
     *
     * @param array $log The form data
     *
     * @return int The new user ID
     */
    public function createLog(array $log): array
    {
        // Insert user
        $logId = $this->repository->insertLog($log);

        $result = [
            'id' => $logId
        ];
        // Logging here: Log created successfully
        //$this->logger->info(sprintf('Log created successfully: %s', $logId));
        return $result;
    }

}