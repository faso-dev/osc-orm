<?php


namespace FSDV\Builder\Syntax;


use FSDV\Builder\QueryBuilderKeyWord;
use PDO;

class UpdateWriter implements WriterInterface
{
    use ParameterBuilderTrait;
    /**
     * @var PDO
     */
    private $connection;

    /**
     * UpdateWriter constructor.
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
        $sql = QueryBuilderKeyWord::UPDATE.' '.$table
            .' '.QueryBuilderKeyWord::SET.' '.$this->buildSetNameParams($culums).' '
    .QueryBuilderKeyWord::WHERE.' '.$table.'.id = :id';
        $this->excute($sql, $this->allParameters($this->buildNameParamsValues($culums, $values), [':id' => $id]));
    }

    /**
     * @param array $culums
     * @return string
     */
    private function buildSetNameParams(array $culums)
    {
        $query = '';
        foreach ($culums as $culum){
            $query .= $culum.' = :'.$culum.' , ';
        }

        return mb_substr($query, 0, strlen($query)-2);
    }
    private function allParameters(array $params, array $param)
    {
        return array_merge($params, $param);
    }
}
