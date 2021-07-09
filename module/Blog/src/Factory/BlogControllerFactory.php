<?php

namespace Blog\Factory;

use Blog\Controller\BlogController;
use Blog\Model\PostRepositoryInterface;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;


class BlogControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return BlogController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new BlogController($container->get(PostRepositoryInterface::class));
    }
}