<?php


namespace ArticleTest\Model;


use Article\Model\Article;
use Article\Model\ArticleTable;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\TableGateway\TableGatewayInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit\TextUI\RuntimeException;
use Prophecy\PhpUnit\ProphecyTrait;

class ArticleTableTest extends TestCase
{
    use ProphecyTrait;

    protected function setUp(): void
    {
        $this->tableGateway = $this->prophesize(TableGatewayInterface::class);
        $this->articleTable = new ArticleTable($this->tableGateway->reveal());
    }

    public function testFetchAllReturnsAllArticles()
    {
        $resultSet = $this->prophesize(ResultSetInterface::class)->reveal();
        $this->tableGateway->select()->willReturn($resultSet);

        $this->assertSame($resultSet, $this->articleTable->fetchAll());
    }

    public function testCanDeleteAnArticleByItsId()
    {
        $this->tableGateway->delete(['id' => 123])->shouldBeCalled();
        $this->articleTable->deleteArticle(123);
    }

    public function testSaveArticleWillInsertNewArticlesIfTheyDontAlreadyHaveAnId()
    {
        $articleData = [
            'artist' => 'The Military Wives',
            'title' => 'In My Dreams'
        ];
        $article = new Article();
        $article->exchangeArray($articleData);

        $this->tableGateway->insert($articleData)->shouldBeCalled();
        $this->articleTable->saveArticle($article);
    }

    public function testSaveArticleWillUpdateExistingArticlesIfTheyAlreadyHaveAnId()
    {
        $articleData = [
            'id' => 123,
            'artist' => 'The Military Wives',
            'title' => 'In My Dreams',
        ];
        $article = new Article();
        $article->exchangeArray($articleData);

        $resultSet = $this->prophesize(ResultSetInterface::class);
        $resultSet->current()->willReturn($article);

        $this->tableGateway
            ->select(['id' => 123])
            ->willReturn($resultSet->reveal());
        $this->tableGateway
            ->update(
                array_filter($articleData, function ($key) {
                    return in_array($key, ['artist', 'title']);
                }, ARRAY_FILTER_USE_KEY),
                ['id' => 123]
            )->shouldBeCalled();

        $this->articleTable->saveArticle($article);
    }

}