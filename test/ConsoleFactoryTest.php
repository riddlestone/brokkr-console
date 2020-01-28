<?php

namespace Riddlestone\Brokkr\Console\Test;

use Riddlestone\Brokkr\Console\ConsoleFactory;
use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;

class ConsoleFactoryTest extends TestCase
{

    public function test__invoke()
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnCallback(function ($id) {
                switch ($id) {
                    case 'Config':
                        return [
                            'console' => [
                                'commands' => [
                                    'TestCommand',
                                ],
                            ],
                        ];
                    case 'TestCommand':
                        return new Command('test-command');
                    default:
                        throw new ServiceNotFoundException();
                }
            });
        $factory = new ConsoleFactory();

        /** @var Application $application */
        $application = $factory($container, Application::class);
        $this->assertInstanceOf(Application::class, $application);
        $this->assertInstanceOf(Command::class, $application->get('test-command'));
    }

    public function test__invoke_withMissingCommand()
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnCallback(function ($id) {
                switch ($id) {
                    case 'Config':
                        return [
                            'console' => [
                                'commands' => [
                                    'TestCommand',
                                ],
                            ],
                        ];
                    default:
                        throw new ServiceNotFoundException();
                }
            });
        $factory = new ConsoleFactory();

        try {
            $factory($container, Application::class);
            $this->fail('Exception not thrown');
        } catch(ServiceNotCreatedException $e) {
            $this->assertInstanceOf(ServiceNotFoundException::class, $e->getPrevious());
            $this->assertEquals('Command "TestCommand" could not be created', $e->getMessage());
        }
    }

    public function test__invoke_withInvalidCommand()
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnCallback(function ($id) {
                switch ($id) {
                    case 'Config':
                        return [
                            'console' => [
                                'commands' => [
                                    'TestCommand',
                                ],
                            ],
                        ];
                    case 'TestCommand':
                        return new stdClass();
                    default:
                        throw new ServiceNotFoundException();
                }
            });
        $factory = new ConsoleFactory();

        try {
            $factory($container, Application::class);
            $this->fail('Exception not thrown');
        } catch(ServiceNotCreatedException $e) {
            $this->assertEquals('"TestCommand" is not a ' . Command::class, $e->getMessage());
        }
    }
}
