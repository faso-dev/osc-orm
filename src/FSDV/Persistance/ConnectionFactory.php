<?php

namespace FSDV\Persistance;


use \PDO;

/**
 * ConnectionFactory class
 * 
 * @package FSDV\Persistance
 * @author faso-dev<faso-dev@protonmail.ch>
 */
class ConnectionFactory
{
    /**
     * Tableau de configuration de la base de donnée.
     * 
     * Database configuration settings.
     * 
     * @var array
     */
    protected $config = [];

    /**
     * L'instance de la connection
     * 
     * The instance of PDO connection
     * 
     * @var null|PDO
     */
    private $connection = null;

    /**
     * ConnectionFactory constructor.
     * 
     * @param array $config
     * @return void
     */
    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }
    
    /**
     * Set configurations to be used for connection.
     * 
     * Définir les configurations à utiliser pour la connexion.
     * 
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config) 
    {
        $this->config = $config;
        
        return $this;
    }
    
    /**
     * Renvoie une instance de PDO avec la connection à la base de donnée créée.
     * 
     * Returns an instance of PDO with the created database connection.
     * 
     * @param array $configuration
     * @return PDO
     * @throws PDOException
     */
    public function create(array $configuration = null): PDO
    {
        $config = $configuration ?? $this->config;
        
        if ($this->connection !== null) {
            return $this->connection;
        }
        
        // Now we can support multiple PDO drivers like pgsql and sqlite.
        switch ($config['driver']) {
            
            case 'mysql':
                $this->connection = $this->mysqlConnection($config);
                
                break;

            default:
                break;
        }
        
        return $this->connection;
    }
    
    /**
     * Get a MySql connection.
     * 
     * Obtenez une connexion MySql.
     * 
     * @param array $config
     * @return PDO
     * @throws PDOException
     */
    protected function mysqlConnection(array $config)
    {
        return new PDO("mysql:host={$config['host']};dbname={$config['database']}", $config['username'], $config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]);
    }
}
