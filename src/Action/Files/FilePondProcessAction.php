<?php
/**
 * Created by PhpStorm.
 * Project: TI
 * User: Miguel Cerejo
 * Date: 4/27/2021
 * Time: 7:16 PM
 *
 * File: FilePondProcessAction.php
 */

namespace App\Action\Files;

use App\Support\FilenameFilter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use RuntimeException;
use Slim\Psr7\UploadedFile;

final class FilePondProcessAction
{
    private $tempDirectory = __DIR__ . '/../../../tmp/upload';

    private $storageDirectory = __DIR__ . '/../../../storage';

    /**
     * Process upload.
     *
     * @see https://pqina.nl/filepond/docs/patterns/api/server/#process
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        /** @var UploadedFile[] $uploadedFiles */
        $uploadedFiles = (array)($request->getUploadedFiles()['filepond'] ?? []);

        if ($uploadedFiles) {
            return $this->moveTemporaryUploadedFile($uploadedFiles, $response);
        }

        $submittedIds = (array)($request->getParsedBody()['filepond'] ?? []);
        if ($submittedIds) {
            return $this->storeUploadedFiles($submittedIds, $response);
        }

        return $response->withStatus(422);
    }

    /**
     * Saves file to unique location and returns unique location id.
     *
     * @param UploadedFile[] $uploadedFiles
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    private function moveTemporaryUploadedFile(
        array $uploadedFiles,
        ResponseInterface $response
    ): ResponseInterface {
        $fileIdentifier = '';

        foreach ($uploadedFiles as $uploadedFile) {
            if ($uploadedFile->getError() !== UPLOAD_ERR_OK) {
                continue;
            }
            $fileIdentifier = $this->moveUploadedFile($this->tempDirectory, $uploadedFile);
        }

        // Server returns unique location id in text/plain response
        $response = $response->withHeader('Content-Type', 'text/plain');
        $response->getBody()->write($fileIdentifier);

        return $response;
    }

    /**
     * Uses the unique id to move the ids to its final location
     * and remove the temp files.
     *
     * @param string[] $submittedIds
     * @param ResponseInterface $response
     *
     * @throws RuntimeException
     *
     * @return ResponseInterface
     */
    private function storeUploadedFiles(
        array $submittedIds,
        ResponseInterface $response
    ): ResponseInterface {
        foreach ($submittedIds as $submittedId) {
            // Save the file into the file storage
            $submittedId = FilenameFilter::createSafeFilename($submittedId);
            $sourceFile = sprintf('%s/%s', $this->tempDirectory, $submittedId);
            $targetFile = sprintf('%s/%s', $this->storageDirectory, $submittedId);

            if (!copy($sourceFile, $targetFile)) {
                throw new RuntimeException(
                    sprintf('Error moving uploaded file %s to the storage', $submittedId)
                );
            }

            if (!unlink($sourceFile)) {
                throw new RuntimeException(
                    sprintf('Error removing uploaded file %s', $submittedId)
                );
            }
        }

        // Server returns unique location id in text/plain response
        $response = $response->withHeader('Content-Type', 'text/plain');

        return $response->withStatus(201);
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
    private function moveUploadedFile(
        string $directory,
        UploadedFileInterface $uploadedFile
    ): string {
        $extension = (string)pathinfo(
            $uploadedFile->getClientFilename(),
            PATHINFO_EXTENSION
        );

        // Create unique id for this file
        $filename = FilenameFilter::createSafeFilename(
            sprintf('%s.%s', (string)uuid_create(), $extension)
        );

        // Save the file into the storage
        $targetPath = sprintf('%s/%s', $directory, $filename);
        $uploadedFile->moveTo($targetPath);

        return $filename;
    }

}