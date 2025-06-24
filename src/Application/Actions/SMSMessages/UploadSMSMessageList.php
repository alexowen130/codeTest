<?php

declare(strict_types=1);

namespace App\Application\Actions\SMSMessages;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Slim\Views\Twig;

class UploadSMSMessageList
{
    private Twig $view;

    /**
     * @param Twig $twig
     */
    public function __construct(Twig $twig)
    {
        $this->view = $twig;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        return $this->view->render($response, 'upload.twig');
    }
}
