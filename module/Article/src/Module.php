<?php


namespace Article;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ArticleTable::class => function($container) {
                    $tableGateway = $container->get(Model\ArticleTableGateway::class);
                    return new Model\ArticleTable($tableGateway);
                },
                Model\ArticleTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Article());
                    return new TableGateway('article', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];

    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ArticleController::class => function($container) {
                    return new Controller\ArticleController(
                        $container->get(Model\ArticleTable::class)
                    );
                },
            ],
        ];
    }
}
