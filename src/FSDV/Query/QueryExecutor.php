<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Query;


use FSDV\Persistance\ConnectionFactory;
use PDO;

/**
 * Class QueryExecutor
 * @package FSDV\Query
 */
class QueryExecutor
{
    /**
     * @var string
     */
    protected $query;
    /**
     * @var PDO
     */
    protected $connection;
    /**
     * @var array
     */
    protected $queryParams;


    /**
     * Query constructor.
     * @param PDO|null $connection
     */
    public function __construct(PDO $connection = null)
    {
        $this->connection = $connection;
    }

    /**
     * @param PDO $connection
     * @return QueryExecutor
     */
    public function setConnection(PDO $connection): QueryExecutor
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @param string $query
     * @return QueryExecutor
     */
    public function setQuery(string $query): QueryExecutor
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return string
     */
    public function getSQLQuery(): string
    {
        return $this->query;
    }

    public function setQueryParams(array $params = null)
    {
        $this->queryParams = $params;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }
}
