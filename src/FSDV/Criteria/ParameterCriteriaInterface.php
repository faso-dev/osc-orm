<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */

namespace FSDV\Criteria;

/**
 * Interface ParameterCriteriaInterface
 * @package FSDV\Criteria
 */
interface ParameterCriteriaInterface
{
    /**
     * @param string $name
     * @param $value
     * @return mixed
     */
    public function setParameter(string $name, $value);

    /**
     * @param array $parameters
     * @return mixed
     */
    public function setParameters(array $parameters);
}
