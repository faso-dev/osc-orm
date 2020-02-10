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

class Query
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
     * @param PDO $connection
     */
    public function __construct(PDO $connection = null) {

        $this->connection = $connection;
    }

    /**
     * @param PDO $connection
     * @return Query
     */
    public function setConnection(PDO $connection): Query
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * @param string $query
     * @return Query
     */
    public function setQuery(string $query): Query
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


    /**
     * @return array
     * @throws Exception
     */
    public function getResults()
    {
        return $this->fetchQuery();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getArrayAssocResult(): array
    {
        return $this->executeQuery()->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $class
     * @return array Collection d'objet de la classe $class
     * @throws Exception
     */
    public function getMappedResultWith(string $class)
    {
        return array_map(function ($datas) use($class) {
            return (new \ReflectionClass($class))->newInstance($datas);
        }, $this->getArrayAssocResult());

    }

    /**
     * @param string $class
     * @return mixed
     * @throws \ReflectionException
     * @throws Exception
     */
    public function getOneMappedWith(string $class)
    {
        return (new \ReflectionClass($class))->newInstance($this->first());
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getArrayResult(): array
    {
        return $this->executeQuery()->fetchAll(PDO::FETCH_NUM);
    }

    /**
     * @return array | null
     * @throws Exception
     */
    public function first(): ?array
    {
        $result =  $this->executeQuery()->fetch(PDO::FETCH_ASSOC);
        if ($result){
            return $result;
        }
        return [];
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function last()
    {
        $results = $this->executeQuery()->fetchAll(PDO::FETCH_ASSOC);
        return end($results);
    }

    /**
     * @param int|null $mode
     * @param string|null $class
     * @return array
     * @throws Exception
     */
    private function fetchQuery(int $mode = null, string $class = null)
    {
        return $this->executeQuery()->fetchAll($mode,$class);
    }

    /**
     * @return bool|PDOStatement
     * @throws Exception
     */
    public function executeQuery()
    {
        if ($this->connection === null){
            throw new Exception("The database connection required to execute query");
        }
        if (!$this->queryParams){
            return $this->query();
        }
        $query = $this->connection->prepare($this->query);
        $query->execute($this->queryParams);
        $this->resetQuery();
        return $query;
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

    /**
     * @return false|PDOStatement
     * @throws Exception
     */
    public function query()
    {
        if ($this->connection === null){
            throw new Exception("The database connection required to execute query");
        }
        return $this->connection->query($this->query);
    }

    /**
     * Reset the query params to empty array
     */
    private function resetQuery()
    {
        $this->queryParams = [];
        $this->query = null;
    }
}
