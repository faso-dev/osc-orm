<?php


namespace FSDV\Persistance;


class ConfigReader
{
    use ConfigParserTrait;
    /**
     * @var string
     */
    protected static $path;
    /**
     * @var array Tableau de configuration de la base de donnée
     */
    protected static $config = [];

    /**
     * ConfigReader constructor.
     * @param string $congig_path
     */
    public function __construct(string $congig_path = null)
    {
        self::$path = $congig_path;
    }

}
