<?php
// In module/Blog/src/Model/ZendDbSqlRepository.php:
namespace Blog\Model;

use InvalidArgumentException;
use RuntimeException;

class ZendDbSqlRepository implements PostRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function findAllPosts()
    {
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function findPost($id)
    {
    }
}