<?php


namespace FSDV\Builder;


use FSDV\Builder\Syntax\QueryBuilderParserParams;
use FSDV\Builder\Syntax\QueryParameterBuilder;
use FSDV\Criteria\ParameterCriteriaInterface;
use FSDV\Criteria\WhereCriteriaInterface;
use FSDV\Query\UpdateQueryExecutor;

/**
 * Class QueryUpdateBuilder
 * @package FSDV\Builder
 */
class QueryUpdateBuilder implements WhereCriteriaInterface, ParameterCriteriaInterface
{
    use QueryParameterBuilder;
    /**
     * @var string
     */
    private $table;
    /**
     * @var array
     */
    private $culums;
    /**
     * @var array
     */
    private $values;
    /**
     * @var string
     */
    private $where;

    /**
     * @var array
     */
    private $parameters;

    public function update(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function setCulums()
    {
        $this->culums = func_get_args();
        return $this;
    }

    public function values()
    {
        $this->values = func_get_args();
        return $this;
    }

    /**
     * @param string $criteria
     * @return $this
     */
    public function where(string $criteria)
    {
        $this->where = $criteria;
        return $this;
    }

    /**
     * @param string $name
     * @param $value
     * @return QueryUpdateBuilder
     */
    public function setParameter(string $name, $value)
    {
        $this->parameters[$name] = $value;
        return $this;
    }

    /**
     * @param array $parameters
     * @return QueryUpdateBuilder
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function buildQuery()
    {
        $query =  QueryBuilderKeyWord::UPDATE.' '.$this->table.' '.QueryBuilderKeyWord::SET
            .' ' .QueryBuilderParserParams::toString($this->buildCulumsWithParametersKeys($this->culums), ', '). ' ';
        if ($this->where){
            $query .= QueryBuilderKeyWord::WHERE. ' ' .$this->where;
        }
        return $query;
    }
    /**
     * @return UpdateQueryExecutor
     * @throws \Exception
     */
    public function getQuery(): UpdateQueryExecutor
    {
        $query = new UpdateQueryExecutor();
        $query->setQuery($this->buildQuery())
            ->setQueryParams(array_merge($this->buildParametersWithValues($this->culums, $this->values), $this->parameters));
        $this->resetBuilder();
        return $query;
    }

    private function resetBuilder()
    {
        $this->where = null;
        $this->table = null;
        $this->parameters = [];
        $this->culums = [];
        $this->values = [];
    }
}

