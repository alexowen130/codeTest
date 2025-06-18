<?php

declare(strict_types=1);

namespace App\Application\Actions\SMSMessages;

use http\Client\Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class UploadSMSMessageList
{
    private $view;

    /**
     * @param Twig $view
     */
    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function __invoke($request, $response, $args): Response
    {
        return $this->view->render($response, 'upload.twig');
    }
}
