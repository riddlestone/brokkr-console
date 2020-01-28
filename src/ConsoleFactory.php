<?php

namespace Riddlestone\Brokkr\Console;

use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Throwable;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class ConsoleFactory
 * @package Riddlestone\Brokkr\Console
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
            try {
                $commandObject = $container->get($command);
            } catch (Throwable $e) {
                throw new ServiceNotCreatedException(sprintf(
                    'Command "%s" could not be created',
                    $command,
                ), 0, $e);
            }
            if (! $commandObject instanceof Command) {
                throw new ServiceNotCreatedException(sprintf('"%s" is not a %s', $command, Command::class));
            }
            $app->add($commandObject);
        }
        return $app;
    }
}
