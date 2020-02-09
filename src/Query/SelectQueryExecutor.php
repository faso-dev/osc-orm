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
        return $this->execute()->fetchAll(PDO::FETCH_NUM);
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function getArrayAssocResults(): ?array
    {
        return $this->execute()->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return array|null
     * @throws Exception
     */
    public function getObjectsResults(): ?array
    {
        return $this->execute()->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @return mixed | null
     * @throws Exception
     */
    public function getFirstArrayAssocResult()
    {
        return $this->execute()->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed | null
     * @throws Exception
     */
    public function getLastArrayAssocResult()
    {
        $results = $this->execute()->fetchAll(PDO::FETCH_ASSOC);
        return end($results);
    }

    /**
     * @param EntityInterface $entity
     * @return mixed | null
     * @throws Exception
     */
    public function getMappedWithClassResults(EntityInterface $entity)
    {

        $results =  $this->execute()->fetchAll(PDO::FETCH_CLASS, $entity);
        return end($results);
    }

    /**
     * @return PDOStatement
     * @throws Exception
     */
    private function execute(): PDOStatement
    {
        if ($this->connection === null){
            throw new Exception("The database connection required to execute query");
        }
        if ($this->queryParams){
            /** @var PDOStatement $query */
            $query = $this->connection->prepare($this->query);
            $query->execute($this->queryParams);
            return $query;
        }
        /** @var PDOStatement $query */
        $query = $this->connection->query($this->query);
        return $query;
    }

}
