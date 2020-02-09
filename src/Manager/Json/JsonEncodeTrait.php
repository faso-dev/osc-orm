<?php


namespace App\Utils\Json;


use FSDV\Extractor\Extractor;

trait JsonEncodeTrait
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
