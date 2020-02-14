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
 * Class DeleteQueryExecutor
 * @package FSDV\Query
 */
class DeleteQueryExecutor extends QueryExecutor
{
    /**
     * DeleteQueryExecutor constructor.
     * @param PDO|null $connection
     */
    public function __construct(PDO $connection = null)
    {
        parent::__construct($connection);
    }

    /**
     * @throws Exception
     */
    public function delete()
    {
        if ($this->connection === null){
            throw new Exception("The database connection required to execute query");
        }
        /** @var PDOStatement $query */
        $query = $this->connection->prepare($this->query);
        $query->execute($this->queryParams);
    }
}
