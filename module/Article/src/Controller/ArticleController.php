<?php
namespace Article\Controller;

use Article\Form\ArticleForm;
use Article\Model\Article;
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

        return ['articles' => $this->table->fetchAll()];
    }

    public function addAction()
    {

        $form = new ArticleForm();

        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $article = new Article();
        $form->setInputFilter($article->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $article->exchangeArray($form->getData());
        $this->table->saveArticle($article);
        return $this->redirect()->toRoute('article');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('article', ['action' => 'add']);
        }

        // Retrieve the article with the specified id. Doing so raises
        // an exception if the article is not found, which should result
        // in redirecting to the landing page.
        try {
            $article = $this->table->getArticle($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('article', ['action' => 'index']);
        }

        $form = new ArticleForm();
        $form->bind($article);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($article->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->saveArticle($article);
        } catch (\Exception $e) {
        }

        // Redirect to article list
        return $this->redirect()->toRoute('article', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('article');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteArticle($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('article');
        }

        return [
            'id'    => $id,
            'article' => $this->table->getArticle($id),
        ];
    }


}
