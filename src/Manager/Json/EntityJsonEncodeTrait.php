<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace App\Utils\Json;


use FSDV\Extractor\Extractor;

/**
 * Trait EntityJsonEncodeTrait
 * @package App\Utils\Json
 */
trait EntityJsonEncodeTrait
{
    /**
     *
     * @throws \ReflectionException
     */
    public function jsonSerialize()
    {
        return Extractor::extractClassPropertiesWithValues($this);
    }
}
