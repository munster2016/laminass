<?php

namespace Blog;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;

class Module
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
//        return [
//            'factories' => [
//                Model\PostTable::class => function($container) {
//                    $tableGateway = $container->get(Model\PostTableGateway::class);
//                    return new Model\PostTable($tableGateway);
//                },
//                Model\PostTableGateway::class => function ($container) {
//                    $dbAdapter = $container->get(AdapterInterface::class);
//                    $resultSetPrototype = new ResultSet();
//                    $resultSetPrototype->setArrayObjectPrototype(new Model\Post());
//                    return new TableGateway('article', $dbAdapter, null, $resultSetPrototype);
//                },
//            ],
//        ];
//
    }

//    public function getControllerConfig()
//    {
//        return [
//            'factories' => [
//                Controller\BlogController::class => function($container) {
//                    return new Controller\BlogController(
//                        $container->get(Model\PostTable::class)
//                    );
//                },
//            ],
//        ];
//    }
}