<?php


namespace Blog\Model;

use InvalidArgumentException;
use Laminas\Db\Sql\Sql;
use Laminas\Hydrator\HydratorInterface;
use RuntimeException;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\Adapter\Driver\ResultInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\Db\ResultSet\HydratingResultSet;


class PostTable
{
    /**
     * @var AdapterInterface
     */
    private $db;


    public function __construct(
        AdapterInterface $db

    ) {
        $this->db            = $db;
    }
    /**
     * Return a set of all blog posts that we can iterate over.
     *
     * Each entry should be a Post instance.
     *
     * @return Post[]
     */
    public function findAllPosts()
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select('post');
        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            return [];
        }

        $resultSet = new HydratingResultSet(
            new ReflectionHydrator(),
            new Post('', '')
        );
        $resultSet->initialize($result);
        return $resultSet;
    }

    public function findPost($id)
    {
        $sql       = new Sql($this->db);
        $select    = $sql->select('post');
        $select->where(['id = ?' => $id]);

        $statement = $sql->prepareStatementForSqlObject($select);
        $result    = $statement->execute();

        if (! $result instanceof ResultInterface || ! $result->isQueryResult()) {
            throw new RuntimeException(sprintf(
                'Failed retrieving blog post with identifier "%s"; unknown database error.',
                $id
            ));
        }

        $resultSet = new HydratingResultSet(
            new ReflectionHydrator(),
            new Post('', '')
        );
        $resultSet->initialize($result);
        $post = $resultSet->current();

        if (! $post) {
            throw new InvalidArgumentException(sprintf(
                'Blog post with identifier "%s" not found.',
                $id
            ));
        }
        return $post;
    }

    public function insertPost(Post $post)
    {

    }

    public function updatePost(Post $post)
    {

    }

    public function deletePost(Post $post)
    {

    }
}