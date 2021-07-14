<?php

namespace Blog;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'aliases' => [
        ],
        'factories' => [
            Controller\PostController::class => Factory\PostControllerFactory::class,
            //Model\PostRepository::class => InvokableFactory::class,

        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\PostController::class => Factory\PostControllerFactory::class,
            Model\PostTable::class => Factory\PostTableFactory::class,
        ],
    ],
    // This lines opens the configuration for the RouteManager
    'router' => [
        // Open configuration for all possible routes
        'routes' => [
            // Define a new route called "blog"
            'blog' => [
                // Define a "literal" route type:
                'type' => Segment::class,
                // Configure the route itself
                'options' => [
                    // Listen to "/post" as uri:
                    'route' => '/blog[/:action]',
                    // Define default controller and action to be called when
                    // this route is matched
                    'defaults' => [
                        'controller' => Controller\PostController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'post' => __DIR__ . '/../view',
        ],
    ],
];