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
   public function __construct() { }

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
