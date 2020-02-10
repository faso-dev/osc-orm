<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Builder\Syntax;


use FSDV\Query\Query;

/**
 * Trait ParameterBuilderTrait
 * @package FSDV\Builder\Syntax
 */
trait ParameterBuilderTrait
{
    /**
     * @param array $params tableau des colonnes
     * @return array tableau de colonnes transformé en tableau de paramètre nommés
     */
    private function builNameParams(array $params)
    {
        return array_map(function ($key){
            return ':'.$key;
        }, $params, $params);
    }

    /**
     * @param array $culums les colones de la table
     * @param array $values les valeurs de la table
     * @return array|false revoie un tableau combiné des deux
     */
    private function buildNameParamsValues(array $culums, array $values)
    {
        return array_combine($this->builNameParams($culums), $values);
    }

    /**
     * @param string $querysql la requête sql avec les paramètre nomé
     * @param array $params    les paramètres et leurs valeurs
     * @throws \Exception
     */
    public function excute(string $querysql, array $params)
    {
        $query = new Query($this->connection);
        $query->setQuery($querysql);
        $query->setQueryParams($params);
        $query->executeQuery();
    }
}
