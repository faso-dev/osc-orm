<?php

/**
 * @copyright All rights reserved
 * @author faso-dev<faso-dev@protonmail.ch>
 * @license MIT
 */
namespace FSDV\Persistance;


trait ConfigParserTrait
{
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
     */
    protected static function BOOT_CONFIG(): void
    {
        $config = [];
        if (file_exists(__DIR__ . '/../../../../config/db_config.ini')){
            $config = file_get_contents(__DIR__ . '/../../../../config/db_config.ini');
        }elseif (self::$path){
            $config = file_get_contents(self::$path);
        }
        if ($config){
            $params = parse_ini_string($config);
            self::$config = $params;
        }
    }

    /**
     * @return array
     */
    public static function GET_CONFIG(): ?array
    {
        self::BOOT_CONFIG();
        return self::$config;
    }
}
