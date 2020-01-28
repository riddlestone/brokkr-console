<?php

namespace Riddlestone\Brokkr\Console;

/**
 * Class Module
 * @package Riddlestone\Brokkr\Console
 */
class Module
{
    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }
}
