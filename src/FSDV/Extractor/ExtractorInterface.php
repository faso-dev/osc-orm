<?php
/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Extractor;
use FSDV\Manager\EntityInterface;

/**
 * Interface ExtractorInterface
 * @package FSDV\Extractor
 */
interface ExtractorInterface
{
    /**
     * @param EntityInterface $class
     * @return array
     *              Extrait les propriétées(attributs) d'une classe
     */
    public static function extractClassProperties(EntityInterface $class);

    /**
     * @param EntityInterface $class
     * @return array
     *              Extrait les valeurs des attributs
     */
    public static function extractClassPropertiesValues(EntityInterface $class);
    /**
     * @param EntityInterface $class
     * @return array
     *              Renvoie un tableau assoiciatif de chaque attribut et sa valeur
     */
    public static function extractClassPropertiesWithValues(EntityInterface $class);

    /**
     * @param EntityInterface $class
     * @return string | EntityInterface
     *               Extrait le nom de la classe
     */
    public static function extractClassName($class);
}
