<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/25/2021
 * Time: 3:42 PM
 *
 * File: HomeAction.php
 */

namespace App\Action;

use App\Domain\Device\Service\Device;
use App\Domain\User\Service\UserLogin;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\Log\Service\Log;

final class ApiAction
{
    /*
     * This file will return always a JSON response
     */
    /**
     * @var Log
     */
    private $logModel;
    /**
     * @var Device
     */
    private $deviceModel;
    /**
     * @var UserLogin
     */
    private $userModel;

    /**
     * ApiAction constructor
     * initiate the variables for any information needed
     * @param Log $logModel
     * @param UserLogin $userModel
     */
    public function __construct(Log $logModel, Device $deviceModel, UserLogin $userModel)
    {
        $this->logModel = $logModel;
        $this->userModel = $userModel;
        $this->deviceModel = $deviceModel;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // return API version
        $response->getBody()->write(json_encode(['version' => '1.0']));
        return $response->withHeader('Content-Type', 'application/json'); //->withStatus(422);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function addLog(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        /*
         * Validate if request his authenticated
         */
        $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
        $pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
        $is_valid = $this->userModel->checkUserLogin($user, $pass);
        // if the user is not valid, will return a user unauthenticated
        if (!$is_valid) {
            // Build the HTTP response
            $response->getBody()->write((string)json_encode(['error' => 'user unauthenticated']));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }

        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        // Invoke the Domain with inputs and retain the result, creating a log
        $log = $this->logModel->createLog($data);
        // Transform the result into the JSON representation
        $result = [
            'log_id' => $log["id"]
        ];
        // Build the HTTP response
        $response->getBody()->write((string)json_encode($result));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $params
     * @return ResponseInterface
     */
    public function getLog(ServerRequestInterface $request, ResponseInterface $response, $params): ResponseInterface {
        /*
         * Validate if request his authenticated
         */
        $user = isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER'] : '';
        $pass = isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW'] : '';
        $is_valid = $this->userModel->checkUserLogin($user, $pass);
        // if the user is not valid, will return a user unauthenticated
        if (!$is_valid) {
            // Build the HTTP response
            $response->getBody()->write((string)json_encode(['error' => 'user unauthenticated']));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }
        // get information from device that is requesting information
        $device = $this->deviceModel->getDeviceInfo(null, null, $params['name']);
        // will get the value, after will be validated if the device needs to be on or off
        // check the device that wants information from
        $result = $this->logModel->getLastLogByDeviceId($device['device_bridge_id']);
        // validates if the device needs to be ON or will return a object based on the last log related to the device
        $info = [];
        if($device["force_on"]) {
            $info["state"] = true;
            $info["value"] = null;
            $info["min_value"] = null;
        } else {
            $info["state"] = ($result["value"] >= $device["switch_value"] ? true : false);
            $info["value"] = $result["value"];
            $info["min_value"] = $device["switch_value"];
        }

        // Build the HTTP response
        $response->getBody()->write((string)json_encode($info));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function addSecurity(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        // Collect input from the HTTP request
        $directory =  __DIR__ . '/public/faces';
        $uploadedFiles = $request->getUploadedFiles();

        // handle single input with single file upload
        $uploadedFile = $uploadedFiles['media'];
        if ($uploadedFiles->getError() === UPLOAD_ERR_OK) {
            //moves file to selected directory
            $filename = $this->moveUploadedFile($directory, $uploadedFile);
            $response->getBody()->write(json_encode(["filename" => $filename]));
        }
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }


    /**
     * Moves the uploaded file to the upload directory and assigns it a unique name
     * to avoid overwriting an existing uploaded file.
     *
     * @param string $directory The directory to which the file is moved
     * @param UploadedFileInterface $uploadedFile The file uploaded file to move
     *
     * @return string The filename of moved file
     */
    function moveUploadedFile(string $directory, UploadedFileInterface $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

        // see http://php.net/manual/en/function.random-bytes.php
        // generates a random string
        $basename = bin2hex(random_bytes(8));
        // gives a name to the file, based in the date and the random string
        $filename = _date('m-d-Y_hia') . "_" .sprintf('%s.%0.8s', $basename, $extension);
        // moves the file to the given directory
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
