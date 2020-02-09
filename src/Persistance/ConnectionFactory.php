<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */

namespace FSDV\Persistance;
use \PDO;

/**
 * Class Persistance
 * @package FSDV\Persistance
 */
class Persistance extends ConfigReader
{
    public function __construct(string $congig_path = null)
    {
        parent::__construct($congig_path);
    }

    /**
     * @var PDO L'instance de la connection
     */
    private static $connection = null;

    /**
     * @return PDO Renvoie une instance de PDO avec la connection à la base de donnée créée
     */
    public static function create(): PDO
    {
        if (null === self::$connection) {
            self::BOOT_CONFIG();
            self::$connection = new PDO("mysql:host=" . self::DB_HOST() . ":" . self::DB_PORT() . ";dbname=" . self::DB_NAME(),
                self::DB_USER(), self::DB_PASSWORD(), [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]);
        }
        return self::$connection;
    }


}
