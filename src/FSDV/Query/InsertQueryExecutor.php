<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Query;


use Exception;
use PDO;
use PDOStatement;

/**
 * Class InsertQueryExecutor
 * @package FSDV\Query
 */
class InsertQueryExecutor extends QueryExecutor
{
    /**
     * InsertQueryExecutor constructor.
     * @param PDO|null $connection
     */
    public function __construct(PDO $connection = null)
    {
        parent::__construct($connection);
    }

    /**
     * @return int|null
     * @throws Exception
     */
    public function save()
    {
        if ($this->connection === null){
            throw new Exception("The database connection required to execute query");
        }
        /** @var PDOStatement $query */
        $query = $this->connection->prepare($this->query);
        $query->execute($this->queryParams);
        return (int)$this->connection->lastInsertId();
    }
}
