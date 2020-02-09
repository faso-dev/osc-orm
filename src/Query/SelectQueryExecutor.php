<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Query;


use Exception;
use FSDV\Manager\EntityInterface;
use PDO;
use PDOStatement;

/**
 * Class SelectQueryExecutor
 * @package FSDV\Query
 */
class SelectQueryExecutor extends QueryExecutor
{
    use SqlQueryGeneratorTrait;

    /**
     * SelectQueryExecutor constructor.
     * @param PDO|null $connection
     */
    public function __construct(PDO $connection = null)
    {
        parent::__construct($connection);
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function getArrayResults(): ?array
    {
        if ($this->connection === null){
            throw new Exception("The database connection required to execute query");
        }
        /** @var PDOStatement $query */
        $query = $this->connection->prepare($this->query);
        $query->execute($this->queryParams);
        return $query->fetchAll(PDO::FETCH_NUM);
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function getArrayAssocResults(): ?array
    {
        if ($this->connection === null){
            throw new Exception("The database connection required to execute query");
        }
        /** @var PDOStatement $query */
        $query = $this->connection->prepare($this->query);
        $query->execute($this->queryParams);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function getObjectsResults(): ?array
    {
        if ($this->connection === null){
            throw new Exception("The database connection required to execute query");
        }
        /** @var PDOStatement $query */
        $query = $this->connection->prepare($this->query);
        $query->execute($this->queryParams);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @return mixed | null
     * @throws Exception
     */
    public function getFirstArrayAssocResult()
    {
        if ($this->connection === null){
            throw new Exception("The database connection required to execute query");
        }
        /** @var PDOStatement $query */
        $query = $this->connection->prepare($this->query);
        $query->execute($this->queryParams);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed | null
     * @throws Exception
     */
    public function getLastArrayAssocResult()
    {
        if ($this->connection === null){
            throw new Exception("The database connection required to execute query");
        }
        /** @var PDOStatement $query */
        $query = $this->connection->prepare($this->query);
        $query->execute($this->queryParams);
        $results =  $query->fetchAll(PDO::FETCH_ASSOC);
        return end($results);
    }

    /**
     * @param EntityInterface $entity
     * @return mixed | null
     * @throws Exception
     */
    public function getMappedWithClassResults(EntityInterface $entity)
    {
        if ($this->connection === null){
            throw new Exception("The database connection required to execute query");
        }
        /** @var PDOStatement $query */
        $query = $this->connection->prepare($this->query);
        $query->execute($this->queryParams);
        $results =  $query->fetchAll(PDO::FETCH_CLASS, $entity);
        return end($results);
    }

}
