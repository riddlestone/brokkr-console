<?php

namespace Riddlestone\ZF\Console;

use Symfony\Component\Console\Application;

return [
    'console' => [
        'commands' => [],
    ],
    'service_manager' => [
        'factories' => [
            Application::class => ConsoleFactory::class,
        ],
    ],
];
