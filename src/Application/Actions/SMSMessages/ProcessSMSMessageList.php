<?php

declare(strict_types=1);

namespace App\Application\Actions\SMSMessages;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

/**
 * Controller for uploading SMS Document to Database
 */
class ProcessSMSMessageList
{
    private ContainerInterface $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        //Get the files Uploaded
        $uploadedFiles = $request->getUploadedFiles();

        // Validate Files are there
        if (!isset($uploadedFiles['sms-file'])) {
            $response->getBody()->write('No file uploaded');
            return $response->withStatus(400);
        }

        $uploadedFile = $uploadedFiles['sms-file'];

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = $uploadedFile->getClientFilename();
            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            //Check is file is a json file
            if (strtolower($extension) !== 'json') {
                $response->getBody()->write('Invalid file type. Only JSON allowed.');
                return $response->withStatus(400);
            }

            $data = file_get_contents($uploadedFile->getFilePath());

            // Check the json file actually contains valid JSON
            if (json_validate($data)) {
                // Insert into DB
                $this->container->get('MessageService')->insertSMSJSON($data);

                $response->getBody()->write('File uploaded successfully');
                return $response;
            }

            $response->getBody()->write('File uploaded successfully');
            return $response;
        }

        $response->getBody()->write('Upload error');
        return $response->withStatus(400);
    }
}
