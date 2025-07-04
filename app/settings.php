<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'db' => [
                    'host' => $_ENV['DB_HOST'] ?? 'localhost',
                    'database' => $_ENV['DB_NAME'] ?? 'slimdb',
                    'username' => $_ENV['DB_USER'] ?? 'slimuser',
                    'password' => $_ENV['DB_PASS'] ?? 'slimpass',
                    'port' => $_ENV['DB_PORT'] ?? 3306,
                ]
            ]);
        }
    ]);
};
