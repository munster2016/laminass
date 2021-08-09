<?php
namespace ArticleTest\Model;

use Article\Model\Article;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    public function testInitialArticleValuesAreNull()
    {
        $article = new Article();

        $this->assertNull($article->artist, '"artist" should be null by default');
        $this->assertNull($article->id, '"id" should be null by default');
        $this->assertNull($article->title, '"title" should be null by default');
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $article = new Article();
        $data  = [
            'artist' => 'some artist',
            'id'     => 123,
            'title'  => 'some title'
        ];

        $article->exchangeArray($data);

        $this->assertSame(
            $data['artist'],
            $article->artist,
            '"artist" was not set correctly'
        );

        $this->assertSame(
            $data['id'],
            $article->id,
            '"id" was not set correctly'
        );

        $this->assertSame(
            $data['title'],
            $article->title,
            '"title" was not set correctly'
        );
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $article = new Article();

        $article->exchangeArray([
            'artist' => 'some artist',
            'id'     => 123,
            'title'  => 'some title',
        ]);
        $article->exchangeArray([]);

        $this->assertNull($article->artist, '"artist" should default to null');
        $this->assertNull($article->id, '"id" should default to null');
        $this->assertNull($article->title, '"title" should default to null');
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
        $article = new Article();
        $data  = [
            'artist' => 'some artist',
            'id'     => 123,
            'title'  => 'some title'
        ];

        $article->exchangeArray($data);
        $copyArray = $article->getArrayCopy();

        $this->assertSame($data['artist'], $copyArray['artist'], '"artist" was not set correctly');
        $this->assertSame($data['id'], $copyArray['id'], '"id" was not set correctly');
        $this->assertSame($data['title'], $copyArray['title'], '"title" was not set correctly');
    }

    public function testInputFiltersAreSetCorrectly()
    {
        $article = new Article();

        $inputFilter = $article->getInputFilter();

        $this->assertSame(3, $inputFilter->count());
        $this->assertTrue($inputFilter->has('artist'));
        $this->assertTrue($inputFilter->has('id'));
        $this->assertTrue($inputFilter->has('title'));
    }
}