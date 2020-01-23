<?php


namespace FSD\Manager;


use FSD\Builder\QueryBuilder;
use PDO;

class ManagerRegistry
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * ManagerRegistry constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    public function createQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder($this->connection);
    }
}
