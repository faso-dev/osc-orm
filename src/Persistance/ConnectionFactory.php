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
class ConnectionFactory
{
    /**
     * @var string
     */
    protected static $path = __DIR__ . '/../../../../../config/db_config.ini';
    /**
     * @var array Tableau de configuration de la base de donnée
     */
    protected static $config = [];
    /**
     * @var PDO L'instance de la connection
     */
    private static $connection = null;

    /**
     * ConnectionFactory constructor.
     * @param string|null $congig_path
     */
    public function __construct(string $congig_path = null)
    {
        if (null !== $congig_path){
            self::$path = $congig_path;
        }
    }

    /**
     * @return PDO Renvoie une instance de PDO avec la connection à la base de donnée créée
     * @throws \Exception
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

    /**
     * @return string Renvoie l'hôte actuel de la base de donée
     */
    public static function DB_HOST(): string
    {
        return self::$config['DB_HOST'];
    }

    /**
     * @return string Renvoie le nom actuel de la base de donée
     */
    public static function DB_NAME(): string
    {
        return self::$config['DB_NAME'];
    }

    /**
     * @return string Renvoie le username actuel de la base de donée
     */
    public static function DB_USER(): string
    {
        return self::$config['DB_USER'];
    }

    /**
     * @return string Renvoie le mot de passe actuel de la base de donée
     */
    public static function DB_PASSWORD(): string
    {
        return self::$config['DB_PASSWORD'];
    }

    /**
     * @return int renvoie le port actuelle de la base de donnée
     */
    public static function DB_PORT(): int
    {
        return self::$config['DB_PORT'];
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected static function BOOT_CONFIG(): void
    {
        if (file_exists(self::$path)){
            $config = file_get_contents(self::$path);
            self::$config = parse_ini_string($config);
        }else{
            throw new \Exception("The file config does not exist");
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function GET_CONFIG(): ?array
    {
        self::BOOT_CONFIG();
        return self::$config;
    }

}
