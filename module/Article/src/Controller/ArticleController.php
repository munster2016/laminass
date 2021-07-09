<?php
namespace Article\Controller;

use Article\Model\ArticleTable;
use \Laminas\View\Model\ViewModel;

class ArticleController extends \Laminas\Mvc\Controller\AbstractActionController
{
    private $table;


    public function __construct(ArticleTable $table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {
//        $article = new ArticleTable();
//        $asd = $article->getArticle(1);
//
//        dd($asd);
        //dd($this->table->fetchAll());
        return ['articles' => $this->table->fetchAll()];
    }

    public function addAction()
    {
    }

    public function updateAction()
    {
    }

    public function deleteAction()
    {
    }


}
