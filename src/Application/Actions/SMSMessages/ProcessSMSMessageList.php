<?php

declare(strict_types=1);

namespace App\Application\Actions\SMSMessages;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Controller for uploading SMS Document to Database
 */
class ProcessSMSMessageList
{
    public function upload(Request $request, Response $response, $args): Response
    {
        $uploadedFiles = $request->getUploadedFiles();

        if (!isset($uploadedFiles['sms-file'])) {
            $response->getBody()->write('No file uploaded');
            return $response->withStatus(400);
        }

        $uploadedFile = $uploadedFiles['sms-file'];

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = $uploadedFile->getClientFilename();
            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            if (strtolower($extension) !== 'json') {
                $response->getBody()->write('Invalid file type. Only JSON allowed.');
                return $response->withStatus(400);
            }

            $uploadedFile->moveTo(__DIR__ . '/../../uploads/' . $filename);

            $response->getBody()->write('File uploaded successfully');
            return $response;
        }

        $response->getBody()->write('Upload error');
        return $response->withStatus(400);
    }
}
