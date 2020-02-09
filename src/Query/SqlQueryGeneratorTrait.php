<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Query;

/**
 * Trait SqlQueryGeneratorTrait
 * @package FSDV\Query
 */
trait SqlQueryGeneratorTrait
{
    /**
     * @return string
     */
    public function getSQLQuery(): string
    {
        return $this->query;
    }
}
