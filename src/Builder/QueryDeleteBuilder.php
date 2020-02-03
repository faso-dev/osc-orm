<?php


namespace FSDV\Builder;


class QueryDeleteBuilder
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $where = [];
    /**
     * @var array
     */
    protected $whereAnd = [];
    /**
     * @var array
     */
    protected $whereOr = [];
    /**
     * @var string
     */
    protected $or;
    /**
     * @var string
     */
    protected $and;
    /**
     * @param string $table
     * @return $this
     */
    public function deleteFrom(string $table)
    {
        $this->query = $table;
        return $this;
    }

    /**
     * @param string $culum
     * @param $value
     * @return $this
     */
    public function where(string $culum, $value)
    {
        $this->where[$culum] = $value;
        return $this;
    }

    /**
     * @return $this
     */
    public function whereAnd()
    {
        $this->whereAnd = func_get_args();
        return $this;
    }

    /**
     * @return $this
     */
    public function whereOr()
    {
        $this->whereOr = func_get_args();
        return $this;
    }

    /**
     * @return $this
     */
    public function or()
    {
        $this->or = QueryBuilderKeyWord::OR;
        return $this;
    }

    /**
     * @return $this
     */
    public function and()
    {
        $this->and = QueryBuilderKeyWord::AND;
        return $this;
    }
}

$builer = new QueryDeleteBuilder();

$builer->deleteFrom('user')
    ->where('username', 'instantech')
    ->and()
    ->where('id', 10)
    ->or()
    ->whereOr('mail','password')
    ->setWhereOrParams('toto@gmail.com','123secret')
    ->execute();

$query = 'DELETE FROM user 
          WHERE (username = instantech AND id = 10) OR (mail = toto@gmail.com OR password = 123secret)'
