<?php


namespace Blog\Factory;


use Blog\Controller\PostController;
use Blog\Model\Post;
use Blog\Model\PostTable;
use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;

class PostControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return PostController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PostController(
            $container->get(PostTable::class),
        );
    }
}