<?php

declare(strict_types=1);

use App\Application\Actions\SMSMessages\ProcessSMSMessageList;
use App\Application\Actions\SMSMessages\UploadSMSMessageList;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

return static function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/sms', function (Group $group) {
        $group->get('/upload', UploadSMSMessageList::class);
        $group->post('/upload', [ProcessSMSMessageList::class, 'upload']);
    });
};
