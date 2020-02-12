<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Builder;


use FSDV\Builder\Syntax\ParameterBuilderTrait;
use FSDV\Builder\Syntax\QueryBuilderParserParams;
use FSDV\Criteria\WhereCriteriaInterface;
use FSDV\Query\SelectQueryExecutor;

/**
 * Class SelectBuilder
 * @package FSDV\Builder
 */
class SelectBuilder implements WhereCriteriaInterface
{
    use ParameterBuilderTrait;
    /**
     * @var array
     */
    protected $string;
    /**
     * @var string
     */
    protected $where;
    /**
     * @var string
     */
    /**
     * @var
     */
    protected $join;
    /**
     * @var string
     */
    protected $groupBy;
    /**
     * @var int
     */
    protected $limit;
    /**
     * @var string
     */
    /**
     * @var array
     */
    protected $from;
    /**
     * @var array
     */
    protected $fromAs;
    /**
     * @var array
     */
    protected $parameters;
    /**
     * @var string
     */
    private $orderBy;
    /**
     * @var string
     */
    private $max;
    /**
     * @var string
     */
    private $count;
    /**
     * @var string
     */
    private $sum;
    /**
     * @var string
     */
    private $avg;
    /**
     * @var string
     */
    private $min;
    /**
     * @var string
     */
    private $culums;
    /**
     * @var string
     */
    private $agregation;

    /**
     * @return $this
     */
    public function select()
    {
        if (func_num_args() === 0)
            $this->culums = '*';
        else {
            $this->culums = QueryBuilderParserParams::toString(func_get_args(), ', ') . ' ';
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function from()
    {
        $this->from = QueryBuilderParserParams::toString(func_get_args(), ', ') . ' ';
        return $this;
    }

    /**
     * @param string $criteria
     * @return $this|mixed
     */
    public function where(string $criteria)
    {
        $this->where = $criteria.' ';
        return $this;
    }

    /**
     * @param string $name
     * @param $value
     * @return $this
     */
    public function setParameter(string $name, $value)
    {
        $this->parameters[$name] = $value;
        return $this;
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @param array $orders
     * @return $this
     */
    public function orderByAsc(array $orders)
    {

        $this->orderBy = QueryBuilderKeyWord::ORDER_BY . ' '
            . QueryBuilderParserParams::toString($orders) . ' '
            . QueryBuilderKeyWord::ASC . ' ';
        return $this;
    }

    /**
     * @param array $orders
     * @return $this
     */
    public function orderByDesc(array $orders)
    {

        $this->orderBy = QueryBuilderKeyWord::ORDER_BY . ' '
            . QueryBuilderParserParams::toString($orders) . ' '
            . QueryBuilderKeyWord::DESC . ' ';
        return $this;
    }

    public function groupBy()
    {
        $this->groupBy = QueryBuilderKeyWord::GROUP_BY . ' '
            . QueryBuilderParserParams::toString(func_get_args(), ', ') . ' ';
        return $this;
    }

    /**
     * @param string $joinTable
     * @param string $criteria
     * @return $this
     */
    public function lefJoin(string $joinTable, string $criteria)
    {
        $this->join = QueryBuilderKeyWord::LEFTJOIN . ' '
            . $joinTable . ' ' . QueryBuilderKeyWord::ON . ' ' . $criteria . ' ';
        return $this;
    }

    /**
     * @param string $joinTable
     * @return $this
     */
    public function naturalJoin(string $joinTable)
    {
        $this->join = QueryBuilderKeyWord::NATURALJOIN . ' '
            . $joinTable . ' ';
        return $this;
    }

    /**
     * @param string $joinTable
     * @param string $criteria
     * @return $this
     */
    public function inerJoin(string $joinTable, string $criteria)
    {
        $this->join = QueryBuilderKeyWord::INNERJOIN . ' '
            . $joinTable . ' ' . QueryBuilderKeyWord::ON . ' ' . $criteria . ' ';
        return $this;
    }

    /**
     * @param string $joinTable
     * @param string $criteria
     * @return $this
     */
    public function rightJoin(string $joinTable, string $criteria)
    {
        $this->join = QueryBuilderKeyWord::RIGHTJOIN . ' '
            . $joinTable . ' ' . QueryBuilderKeyWord::ON . ' ' . $criteria . ' ';
        return $this;
    }

    /**
     * @param string $culum
     * @param string|null $alias
     * @return $this
     */
    public function sum(string $culum, string $alias = null)
    {
        $this->agregation = QueryBuilderKeyWord::SUM . '(' . $culum . ')';
        if ($alias) {
            $this->agregation .= ' AS ' . $alias . ' ';
        }
        return $this;
    }

    /**
     * @param string $culum
     * @param string|null $alias
     * @return $this
     */
    public function max(string $culum, string $alias = null)
    {
        $this->agregation = QueryBuilderKeyWord::MAX . '(' . $culum . ')';
        if ($alias) {
            $this->agregation .= ' AS ' . $alias . ' ';
        }
        return $this;
    }

    /**
     * @param string $culum
     * @param string|null $alias
     * @return $this
     */
    public function min(string $culum, string $alias = null)
    {
        $this->agregation = QueryBuilderKeyWord::MIN . '(' . $culum . ')';
        if ($alias) {
            $this->agregation .= ' AS ' . $alias . ' ';
        }
        return $this;
    }

    /**
     * @param string $culum
     * @param string|null $alias
     * @return $this
     */
    public function count(string $culum, string $alias = null)
    {
        $this->agregation = QueryBuilderKeyWord::COUNT . '(' . $culum . ')';
        if ($alias) {
            $this->agregation .= ' AS ' . $alias . ' ';
        }
        return $this;
    }

    /**
     * @param string $culum
     * @param string|null $alias
     * @return $this
     */
    public function avg(string $culum, string $alias = null)
    {
        $this->agregation = QueryBuilderKeyWord::AVG . '(' . $culum . ')';
        if ($alias) {
            $this->agregation .= ' AS ' . $alias . ' ';
        }
        return $this;
    }

    /**
     * @param int $per_page
     * @param $page
     * @return SelectBuilder
     */
    public function paginate(int $per_page, $page = 0)
    {
        $this->limit = QueryBuilderKeyWord::LIMIT . ' '
            . $per_page . ' ' . QueryBuilderKeyWord::OFSET . ' ' . $page . ' ';
        return $this;
    }


    /**
     * reset the builder
     */
    private function resetBuilder()
    {
        $this->where = null;
        $this->culums = null;
        $this->join = null;
        $this->from = [];
        $this->groupBy = null;
        $this->limit = null;
        $this->avg = null;
        $this->max = null;
        $this->min = null;
        $this->sum = null;
        $this->count = null;
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function buildQuery()
    {
        $query = QueryBuilderKeyWord::SELECT . ' ';
        if ($this->culums) {
            $query .= $this->culums . ' ';
        } else {
            $query .= $this->agregation . ' ';
        }
        $query .= QueryBuilderKeyWord::FROM . ' ' . $this->from . ' ';
        if ($this->join) {
            $query .= $this->join;
        }
        if ($this->where) {
            $query .= QueryBuilderKeyWord::WHERE . ' ' . $this->where;
        }
        if ($this->groupBy) {
            $query .= $this->groupBy;
        }
        if ($this->orderBy) {
            $query .= $this->orderBy;
        }
        if ($this->limit) {
            $query .= $this->limit;
        }
        return $query;
    }

    /**
     * @return SelectQueryExecutor
     * @throws \Exception
     */
    public function getQuery(): SelectQueryExecutor
    {
        $query = new SelectQueryExecutor();
        $query->setQuery($this->buildQuery())
            ->setQueryParams($this->parameters);
        $this->resetBuilder();
        return $query;
    }

}

