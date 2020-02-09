<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Manager;

use App\Utils\Json\JsonEncodeTrait;

/**
 * Interface EntityInterface
 * @package FSDV\Manager
 */
interface EntityInterface extends \JsonSerializable
{
    /**
     * Hydrate an entity object
     * @param array|null $data
     * @return mixed
     */
    public function hydrate(array $data = []);

    /**
     * Renvoie l'id de l'entité courante
     * @return integer | null
     */
    public function getId(): ?int;

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id);

    /**
     * @return array|null
     */
    public function getValidationRules(): ?array;
}
