<?php


namespace FSDV\Builder\Syntax;


trait QueryParameterBuilder
{
    /**
     * @param array $culums
     * @param array $values
     * @return array|null
     */
    private function buildParametersWithValues(array $culums, array $values): ?array
    {
        if (count($culums) !== count($values)){
            throw new \Exception(sprintf("The culums size does not match with the values size : %d culums with %d values", count($culums), count($values)));
        }
        $parametersWithValues = array_combine($this->setNamedParameters($culums), $values);
        return $parametersWithValues;
    }

    /**
     * @param array $params
     * @return array
     */
    private function setNamedParameters(array $params)
    {
        return array_map(function ($key){
            return ':'.$key;
        }, $params);

    }
}
