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
     * @param string $table
     * @return QueryInsertBuilder
     */
    public static function insertInto(string $table)
    {
        return (new QueryInsertBuilder())
            ->insertInTo($table);
    }

    /**
     * @param string $table
     * @return QueryUpdateBuilder
     */
    public static function update(string $table)
    {
        return (new QueryUpdateBuilder())
            ->update($table);
    }

    /**
     * @param string $table
     * @return QueryDeleteBuilder
     */
    public static function deleteFrom(string $table)
    {
        return (new QueryDeleteBuilder())
            ->deleteFrom($table);
    }

    /**
     * @return SelectBuilder
     */
    public static function select()
    {
        return func_num_args() > 0 ? (new SelectBuilder())
            ->select(implode(',', func_get_args())) :
            (new SelectBuilder())
                ->select();
    }
}
