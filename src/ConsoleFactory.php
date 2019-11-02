<?php

namespace Clockwork\Console;

use Exception;
use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
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
            try {
                $command = $container->get($command);
            } catch (Exception $e) {
                throw new ServiceNotCreatedException(sprintf(
                    'Command "%s" could not be created: %s',
                    $command,
                    $e->getMessage()
                ), 0, $e);
            }
            if (! $command instanceof Command) {
                throw new ServiceNotCreatedException(sprintf('"%s" is not a %s', $command, Command::class));
            }
            $app->add($container->get($command));
        }
        return $app;
    }
}
