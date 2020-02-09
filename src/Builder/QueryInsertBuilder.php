<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Builder;


use FSDV\Builder\Syntax\QueryBuilderParserParams;
use FSDV\Builder\Syntax\QueryParameterBuilder;
use FSDV\Query\Query;

/**
 * Class QueryInsertBuilder
 * @package FSDV\Builder
 */
class QueryInsertBuilder
{
    use QueryParameterBuilder;

    /**
     * @var array
     */
    protected $culums;

    /**
     * @var array
     */
    protected $values;

    /**
     * @var string
     */
    protected $table;

    /**
     * @param string $table
     * @return $this
     */
    public function insertInTo(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return $this
     */
    public function culums(): self
    {
        $this->culums = func_get_args();
        return $this;
    }

    /**
     * @return $this
     */
    public function values(): self
    {
        $this->values = func_get_args();
        return $this;
    }

    /**
     * @return string
     */
    private function buildQuery()
    {
        return QueryBuilderKeyWord::INSERT.' '
            .$this->table.' ('.QueryBuilderParserParams::toString($this->culums).') '
            .QueryBuilderKeyWord::VALUES.'('.QueryBuilderParserParams::toString($this->setNamedParameters($this->culums)).')';
    }

    /**
     * @return Query
     * @throws \Exception
     */
    public function getQuery(): Query
    {
       $query = new Query();
       $query->setQuery($this->buildQuery())
            ->setQueryParams($this->buildParametersWithValues($this->culums, $this->values));
       $this->resetBuilder();
       return $query;
    }

    private function resetBuilder()
    {
        $this->table = null;
        $this->culums = [];
        $this->values = [];
    }

}

