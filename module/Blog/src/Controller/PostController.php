<?php


namespace Blog\Controller;


use Blog\Model\Post;
use Blog\Model\PostTable;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Sql\Sql;
use Laminas\Hydrator\HydratorInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class PostController extends AbstractActionController
{
    private $table;
    /**
     * PostController constructor.
     */
    public function __construct(PostTable $table)
    {
        $this->table = $table;

    }

    public function indexAction()
    {
        //$posts = $this->table->findAllPosts();
        $posts = $this->table->findPost(1);

        return ['posts' => $posts];
    }

    public function addAction()
    {

    }

    public function editAction()
    {

    }

    public function deleteAction()
    {

    }
}