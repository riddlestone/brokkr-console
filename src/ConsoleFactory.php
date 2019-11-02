<?php

namespace Clockwork\Console;

use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class ConsoleFactory
 * @package Console
 */
class ConsoleFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $app = new Application();
        foreach ($container->get('Config')['console']['commands'] as $command) {
            $app->add($container->get($command));
        }
        return $app;
    }
}
