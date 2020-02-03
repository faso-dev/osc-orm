<?php

/**
 * @author faso-dev<faso@protonmail.ch>
 * @version 1.0
 * @license MIT
 *
 */

namespace FSDV\Builder\Syntax;


use FSDV\Builder\QueryBuilderKeyWord;
use FSDV\Query\Query;
use PDO;

/**
 * Class InsertIntoWriter
 * @package FSDV\Builder\Syntax
 */
class InsertInToWriter implements WriterInterface
{
    use ParameterBuilderTrait;
    /**
     * @var PDO instane de la connexion
     */
    private $connection;

    /**
     * InsertIntoWriter constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param string $table le nom de la table
     * @param array $culums les colonnes de la table
     * @param array $values les valeurs des colonnes
     * @param int|null $id
     */
    public function write(string $table, array $culums, array $values, int $id = null)
    {
       $sql = QueryBuilderKeyWord::INSERT.$table.' ( '.implode(',', $culums).') '
           .QueryBuilderKeyWord::VALUES.' ('.implode(', ', $this->builNameParams($culums)).')';

       $this->excute($sql, $this->buildNameParamsValues($culums, $values));
    }

}
