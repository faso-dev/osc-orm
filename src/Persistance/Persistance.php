<?php


namespace FSDV\Persistance;
use \PDO;

class Persistance
{
    /**
     * @var PDO L'instance de la connection
     */
    private static $connection = null;

    /**
     * @var array Tableau de configuration de la base de donnée
     */
    private static $config = [];

    /**
     * @return PDO Renvoie une instance de PDO avec la connection à la base de donnée créée
     */
    public static function getConnection(): PDO
    {
        if (null === self::$connection) {
            self::setDB_CONFIG();
            self::$connection = new PDO("mysql:host=" . self::getDB_HOST() . ":" . self::getDB_PORT() . ";dbname=" . self::getDB_NAME(),
                self::getDB_USER(), self::getDB_PASSWORD(), [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]);
        }
        return self::$connection;
    }

    /**
     * @return string Renvoie l'hôte actuel de la base de donée
     */
    public static function getDB_HOST(): string
    {
        return self::$config['DB_HOST'];
    }

    /**
     * @return string Renvoie le nom actuel de la base de donée
     */
    public static function getDB_NAME(): string
    {
        return self::$config['DB_NAME'];
    }

    /**
     * @return string Renvoie le username actuel de la base de donée
     */
    public static function getDB_USER(): string
    {
        return self::$config['DB_USER'];
    }

    /**
     * @return string Renvoie le mot de passe actuel de la base de donée
     */
    public static function getDB_PASSWORD(): string
    {
        return self::$config['DB_PASSWORD'];
    }

    /**
     * @return int renvoie le port actuelle de la base de donnée
     */
    public static function getDB_PORT(): int
    {
        return self::$config['DB_PORT'];
    }

    /**
     * @return void
     */
    private static function setDB_CONFIG(): void
    {
        $config_file = file_get_contents(__DIR__ . '/../../../../config/config_bd.ini');
        $params = parse_ini_string($config_file);
        self::$config = $params;
    }
}
