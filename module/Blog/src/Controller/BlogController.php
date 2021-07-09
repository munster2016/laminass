<?php


namespace Blog\Controller;

use Blog\Model\PostRepository;
use Laminas\Mvc\Controller\AbstractActionController;
use Blog\Model\PostRepositoryInterface;
use Laminas\View\Model\ViewModel;

class BlogController extends AbstractActionController
{
    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;
    /**
     * BlogController constructor.
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function indexAction()
    {

        $posts = $this->postRepository->findAllPosts();
       // dd($posts);

        return ['posts' => $posts];
    }

    public function addAction()
    {

    }
}