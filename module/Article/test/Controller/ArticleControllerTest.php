<?php

namespace ArticleTest\Controller;

use Article\Controller\ArticleController;
use Article\Model\Article;
use Article\Model\ArticleTable;
use Laminas\Db\Adapter\Adapter;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;


class ArticleControllerTest extends AbstractHttpControllerTestCase
{

    use ProphecyTrait;


    protected $traceError = true;

    protected $articleTable;

    protected function setUp() : void
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
        // Grabbing the full application configuration:
            include __DIR__ . '/../../../../config/application.config.php',
            $configOverrides
        ));
        parent::setUp();

        $this->configureServiceManager($this->getApplicationServiceLocator());

    }

    public function testIndexActionCanBeAccessed()
    {
        $this->articleTable->fetchAll()->willReturn([]);

        $this->dispatch('/article');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Article');
        $this->assertControllerName(ArticleController::class);
        $this->assertControllerClass('ArticleController');
        $this->assertMatchedRouteName('article');
    }


    protected function configureServiceManager(ServiceManager $services)
    {
        $services->setAllowOverride(true);

        $services->setService('config', $this->updateConfig($services->get('config')));
        $services->setService(ArticleTable::class, $this->mockAArticleTable()->reveal());

        $services->setAllowOverride(false);
    }

    protected function updateConfig($config)
    {
        $config['db'] = [];
        return $config;
    }

    protected function mockAArticleTable()
    {
        $this->articleTable = $this->prophesize(ArticleTable::class);
        return $this->articleTable;
    }

    public function testAddActionRedirectsAfterValidPost()
    {
        $this->articleTable
            ->saveArticle(Argument::type(Article::class))
            ->shouldBeCalled();

        $postData = [
            'title'  => 'Led Zeppelin III',
            'artist' => 'Led Zeppelin',
            'id'     => '',
        ];
        $this->dispatch('/article/add', 'POST', $postData);
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/article');
    }
}