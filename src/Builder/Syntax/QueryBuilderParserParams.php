<?php


namespace FSDV\Builder\Syntax;


class QueryBuilderParserParams
{
    /**
     * @param array $data
     * @param string $delimiter
     * @return string
     */
    public static function toString(array $data, string $delimiter = ',')
    {
        return implode($delimiter, $data);
    }

    /**
     * @param string $data
     * @param string $delimiter
     * @return array
     */
    public static function toArray(string $data, string $delimiter = ',')
    {
        return explode($delimiter, $data);
    }
    
}
