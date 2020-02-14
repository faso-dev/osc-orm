<?php


namespace FSDV\DB;


use FSDV\Builder\QueryDeleteBuilder;
use FSDV\Builder\QueryInsertBuilder;
use FSDV\Builder\QueryUpdateBuilder;
use FSDV\Builder\SelectBuilder;

/**
 * Class DB
 * @package FSDV\DB
 */
class DB
{
    /**
     * @return QueryInsertBuilder
     */
    public static function insert()
    {
        return new QueryInsertBuilder();
    }

    /**
     * @return QueryUpdateBuilder
     */
    public static function update()
    {
        return new QueryUpdateBuilder();
    }

    /**
     * @return QueryDeleteBuilder
     */
    public static function delete()
    {
        return new QueryDeleteBuilder();
    }

    /**
     * @return SelectBuilder
     */
    public static function select()
    {
        return new SelectBuilder();
    }
}
