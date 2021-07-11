<?php

namespace Article\Model;

use Laminas\ServiceManager\ServiceManager;

use RuntimeException;
use Laminas\Db\TableGateway\TableGatewayInterface;

class ArticleTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getArticle($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveArticle(Article $article)
    {
        $data = [
            'artist' => $article->artist,
            'title'  => $article->title,
        ];

        $id = (int) $article->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getArticle($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteArticle($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}