<?php

namespace Clockwork\Console\Test;

use Clockwork\Console\Module;
use PHPUnit\Framework\TestCase;

class ModuleTest extends TestCase
{

    public function testGetConfig()
    {
        $module = new Module();
        $config = $module->getConfig();
        $this->assertIsArray($config);
        $this->assertArrayHasKey('console', $config);
        $this->assertArrayHasKey('service_manager', $config);
        $this->assertIsArray($config['service_manager']);
        $this->assertArrayHasKey('factories', $config['service_manager']);
        $this->assertIsArray($config['service_manager']['factories']);
        $this->assertArrayHasKey('Symfony\Component\Console\Application', $config['service_manager']['factories']);
    }
}
