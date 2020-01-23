<?php


namespace FSD\Query;

use App\Entity\Post;
use PDO;

class Query
{
    //use QueryResult;
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
    public function __construct(PDO $connection) {

        $this->connection = $connection;
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
    public function getResults()
    {
        return $this->fetchQuery();
    }

    public function firstResult()
    {

    }

    public function lastResult()
    {

    }

    /**
     * @return array
     */
    public function getArrayAssocResult(): array
    {
        return $this->executeQuery()->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * @return array
     */
    public function getArrayResult(): array
    {
        return $this->executeQuery()->fetchAll(PDO::FETCH_NUM);
    }

    public function getObjectResult(string $class)
    {
        return $this->fetchQuery(PDO::FETCH_CLASS, $class);
    }

    public function first(string $class = null)
    {
        return $this->executeQuery()->fetch(PDO::FETCH_ORI_FIRST);
    }

    public function last(string $class = null)
    {
        return end($this->executeQuery()->fetchAll(PDO::FETCH_CLASS, $class));
    }
    private function fetchQuery(int $mode = null, string $class = null)
    {
        return $this->executeQuery()->fetchAll($mode,$class);
    }
    private function executeQuery()
    {
        if ($this->queryParams){
            $query = $this->connection->prepare($this->query);
            return $query->execute($this->queryParams);
        }else{
            return $this->connection->query($this->query);
        }

    }
}
