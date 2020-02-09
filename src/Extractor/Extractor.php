<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Extractor;

use FSDV\Manager\EntityInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;
use function count;

/**
 * Class Extractor
 * @package FSDV\Extractor
 */
class Extractor implements ExtractorInterface
{

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public static function extractClassProperties(EntityInterface $class)
    {
        $class = new ReflectionClass($class);
        /** @var ReflectionProperty $properties */
        $properties = $class->getProperties();
        return array_map(function (ReflectionProperty $property){
            return $property->getName();
        },(array)$properties);
    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public static function extractClassPropertiesValues(EntityInterface $class)
    {
        /** @var ReflectionClass $reflectedClass */
        $reflectedClass = new ReflectionClass($class);
        /** @var ReflectionProperty $properties */
        $properties = $reflectedClass->getProperties();
        return array_map(function (ReflectionProperty $property) use ($reflectedClass, $class){
            $property->setAccessible(true);
            $method = 'get'.ucwords(str_replace('_', '', $property->getName()));
            /** @var ReflectionMethod $method */
            $method = $reflectedClass->getMethod($method);
            return $method->invoke($class);
        }, (array)$properties);
    }

    /**
     * @param array $fields
     * @param string $field
     * @return array
     */
    public static function hidenArrayField(array $fields, string $field)
    {
        return array_filter($fields, function () use ($field, $fields){
            return !array_key_exists($field, $fields);
        });
    }
    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public static function extractClassPropertiesWithValues(EntityInterface $class)
    {
       return array_combine(
           self::extractClassProperties($class),
           self::extractClassPropertiesValues($class));
    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public static function extractClassName($class)
    {
        $className = explode('\\', strtolower((new ReflectionClass($class))->getName()));
        return end($className);
    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public static function count(EntityInterface $class)
    {
        return count(self::extractClassProperties($class));
    }


}
