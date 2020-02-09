<?php


namespace FSDV\Builder;


use FSDV\Builder\Syntax\QueryParameterBuilder;
use FSDV\Query\DeleteQueryExecutor;

/**
 * Class QueryDeleteBuilder
 * @package FSDV\Builder
 */
class QueryDeleteBuilder
{
    use QueryParameterBuilder;
    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $where ;

    /**
     * @var array
     */
    protected $parameters;

    /**
     * @param string $table
     * @return $this
     */
    public function deleteFrom(string $table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @param string $criterias
     * @return QueryDeleteBuilder
     */
    public function where(string $criterias)
    {
        $this->where = $criterias;
        return $this;
    }

    /**
     * @param string $name
     * @param $value
     * @return QueryDeleteBuilder
     */
    public function setParameter(string $name, $value)
    {
        $this->parameters[$name] = $value;
        return $this;
    }

    /**
     * @param array $parameters
     * @return QueryDeleteBuilder
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * reset the builder
     */
    private function resetBuilder()
    {
        $this->where = null;
        $this->table = null;
        $this->parameters = [];
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function buildQuery()
    {
        $query =  QueryBuilderKeyWord::DELETE.' '.QueryBuilderKeyWord::FROM. ' ' .$this->table.' '
            .' ' ;
        if ($this->where){
            $query .= QueryBuilderKeyWord::WHERE. ' ' .$this->where;
        }
        return $query;
    }
    /**
     * @return DeleteQueryExecutor
     * @throws \Exception
     */
    public function getQuery(): DeleteQueryExecutor
    {
        $query = new DeleteQueryExecutor();
        $query->setQuery($this->buildQuery())
            ->setQueryParams($this->parameters);
        $this->resetBuilder();
        return $query;
    }

}



