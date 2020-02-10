<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Criteria;

/**
 * Interface WhereCriteriaInterface
 * @package FSDV\Criteria
 */
interface WhereCriteriaInterface
{
    /**
     * @param string $criteria
     * @return mixed
     */
    public function where(string $criteria);
}
