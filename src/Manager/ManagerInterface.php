<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Manager;

/**
 * Interface ManagerInterface
 * @package FSDV\Manager
 */
interface ManagerInterface
{
    /**
     * @param mixed $class
     * @return void
     *             Stocke les données à enregistrer en base de donnée
     */
    public function save(EntityInterface $class);

    /**
     * @param mixed $class
     * @return void
     *             Supprime l'entité de la base de donnée
     */
    public function remove(EntityInterface $class);

    /**
     * @param mixed $class
     * @return void
     *             Supprime l'entité de la base de donnée
     */
    public function update(EntityInterface $class);

    /**
     * @return void
     *             Enregistre les données dans la base de donnée
     */
    public function commit();
}
