<?php


namespace FSD\Builder;


use FSD\Query\Query;
use \PDO;

class QueryBuilder
{
    /**
     * @var array
     */
    protected $fields;
    /**
     * @var array
     */
    protected $where;
    /**
     * @var array
     */
    protected $whereOr;
    /**
     * @var array
     */
    protected $orWhere;
    /**
     * @var array
     */
    protected $andWhere;
    /**
     * @var
     */
    protected $lefJoin;
    /**
     * @var
     */
    protected $rightJoin;
    /**
     * @var array
     */
    protected $innerJoin;
    /**
     * @var
     */
    protected $join;
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
    protected $query;
    /**
     * @var PDO
     */
    private $connection;

    public function __construct(PDO $connection = null)
    {
        $this->connection = $connection;
        $this->query = "";
    }


    public function select()
    {
        $this->fields = func_get_args();
        return $this;
    }

    public function from()
    {
        $this->from = func_get_args();
        return $this;
    }

    public function fromAs(string $table, string $alias)
    {
        $classname = explode('\\', $table);
        $this->fromAs[] =  strtolower(end($classname))." AS ".strtolower($alias);
        return $this;
    }

    public function where()
    {
        foreach (func_get_args() as $arg) {
            $this->where[] = $arg;
        }

        return $this;
    }

    public function whereOr()
    {
        foreach (func_get_args() as $arg) {
            $this->whereOr[] = $arg;
        }

        return $this;
    }

    public function whereAnd()
    {
        foreach (func_get_args() as $arg) {
            $this->where[] = $arg;
        }

        return $this;
    }

    public function orWhere()
    {
        foreach (func_get_args() as $arg) {
            $this->orWhere[] = $arg;
        }

        return $this;
    }

    public function andWhere()
    {
        foreach (func_get_args() as $arg) {
            $this->andWhere[] = $arg;
        }

        return $this;
    }

    public function setParameters(array $params)
    {
        $this->parameters = $params;
        return $this;
    }

    public function join()
    {
        $this->join = func_get_args();
        return $this;
    }

    public function lefJoin()
    {
        $this->lefJoin = func_get_args();
        return $this;
    }

    public function rightJoin()
    {
        $this->rightJoin = func_get_args();
        return $this;
    }

    /**
     * @return string
     */
    private function buildQuery(): string
    {

        $query =  $this->buildSelect()
            . ' ' . QueryBuilderKeyWord::FROM
            . ' ' . $this->buildFrom() . ' ' . $this->buildFromAs()
                ;
        $query .= ' '. $this->buildWhereQueryIfWhereCriteriaExist();
        $query .= ' '. $this->buildAllJoinQueryIfJoinCriteriaExist();

        return $query;
    }

    /**
     * Check if the join method called
     * @return bool
     */
    private function hasJoinCriteria(): bool
    {
        return null !== $this->join;
    }
    /**
     * Check if the lefjoin method called
     * @return bool
     */
    private function hasLeftJoinCriteria(): bool
    {
        return null !== $this->lefJoin;
    }
    /**
     * Check if the rightjoin method called
     * @return bool
     */
    private function hasRightJoinCriteria(): bool
    {
        return null !== $this->rightJoin;
    }
    /**
     * Check if the innerjoin method called
     * @return bool
     */
    private function hasInnerJoinCriteria(): bool
    {
        return null !== $this->innerJoin;
    }

    /**
     * Check if any where method called
     * @return bool
     */
    private function hasWhereCriteria(): bool
    {
        return $this->where || $this->orWhere || $this->andWhere;
    }
    /**
     * @return Query
     */
    public function getQuery(): Query
    {
        $query = new Query($this->connection);

        $query
            ->setQuery($this->buildQuery())
            ->setQueryParams($this->parameters)
        ;
        return $query;
    }

    private function buildWhere()
    {
        if ($this->where) {
            return implode(' ' . QueryBuilderKeyWord:: AND . ' ', $this->where);
        }
        return '';
    }

    private function buildWhereOr()
    {
        if ($this->whereOr) {
            return implode(' ' . QueryBuilderKeyWord:: OR . ' ', $this->whereOr);
        }
        return '';
    }

    private function buildOrWhere()
    {
        if ($this->orWhere) {
            return ' ' . QueryBuilderKeyWord:: OR . ' ' . implode(' ' . QueryBuilderKeyWord:: OR . ' ', $this->orWhere);
        }
        return '';
    }

    private function buildAndWhere()
    {
        if ($this->orWhere) {
            return ' ' . QueryBuilderKeyWord:: AND . ' ' . implode(' ' . QueryBuilderKeyWord:: AND . ' ', $this->andWhere);
        }
        return '';
    }

    /**
     * @return string
     */
    private function buildFrom(): string
    {
        if ($this->from) {
            return implode(', ', $this->from);
        }
        return '';
    }

    /**
     * @return string
     */
    private function buildFromAs(): string
    {
        if ($this->fromAs) {
            return implode(', ', $this->fromAs);
        }
        return '';
    }

    /**
     * @return string
     */
    private function buildSelect()
    {
        if ($this->fields) {
            return QueryBuilderKeyWord::SELECT
                . ' ' . implode(', ', $this->fields);
        }
        return '';

    }

    /**
     *
     * @return string
     */
    private function buildWhereQueryIfWhereCriteriaExist(): string
    {
        if ($this->hasWhereCriteria()) {
            return  ' ' . QueryBuilderKeyWord::WHERE
                . ' ' . $this->buildWhere()
                . ' ' . $this->buildWhereOr()
                . ' ' . $this->buildOrWhere()
                . ' ' . $this->buildAndWhere();
        }
        return '';
    }

    /**
     * @return string
     */
    private function buildAllJoinQueryIfJoinCriteriaExist(): string
    {
        $query = "";
        if ($this->hasJoinCriteria()) {
            $query .= QueryBuilderKeyWord::JOIN
                . ' ' . $this->buildJoin();
        }
        if ($this->hasLeftJoinCriteria()) {
            $query .= QueryBuilderKeyWord::LEFTJOIN
                . ' ' . $this->buildLeftJoin();
        }
        if ($this->hasRightJoinCriteria()) {
            $query .= QueryBuilderKeyWord::RIGHTJOIN
                . ' ' . $this->buildRightJoin();
        }
        if ($this->hasInnerJoinCriteria()){
            $query .= QueryBuilderKeyWord::INNERJOIN
                .' '. $this->buildInnerJoin();
        }
        return $query;
    }

    private function buildJoin()
    {

    }

    private function buildLeftJoin()
    {
        return implode(' ON ', $this->lefJoin);
    }

    private function buildRightJoin()
    {
    }

    private function buildInnerJoin()
    {
    }

}
