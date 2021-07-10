<?php

namespace Article;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
//    'controllers' => [
//        'factories' => [
//            Controller\ArticleController::class => InvokableFactory::class,
//        ],
//    ],
    'router' => [
        'routes' => [
            'article' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/article[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ArticleController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'article' => __DIR__ . '/../view',
        ],
    ],
];
