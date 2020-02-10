<?php

namespace FSDV\Builder\Syntax;


/**
 * interface InsertIntoWriter
 * @package FSDV\Builder\Syntax
 */
interface WriterInterface
{
    /**
     * @param string $table le nom de la table
     * @param array $culums les colonnes de la table
     * @param array $values les valeurs des colonnes
     * @param int|null $id
     */
    public function write(string $table, array $culums, array $values, int $id = null);

    /**
     * @param string $querysql la requête sql avec les paramètre nomé
     * @param array $params    les paramètres et leurs valeurs
     */
    public function excute(string $querysql, array $params);
}
