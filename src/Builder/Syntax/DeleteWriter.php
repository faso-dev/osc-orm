<?php


namespace FSDV\Builder\Syntax;


use FSDV\Builder\QueryBuilderKeyWord;
use PDO;

class DeleteWriter implements WriterInterface
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
     * @inheritDoc
     */
    public function write(string $table, array $culums, array $values, int $id = null)
    {
        $sql = QueryBuilderKeyWord::DELETE.' '.QueryBuilderKeyWord::FROM.' '.$table
            .' '.QueryBuilderKeyWord::WHERE.' '.$culums[0].' = '.implode(', ', $this->builNameParams($culums));
        $this->excute($sql, $this->buildNameParamsValues($culums, $values));
    }

}
