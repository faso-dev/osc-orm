<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Query;


use PDO;

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
}
