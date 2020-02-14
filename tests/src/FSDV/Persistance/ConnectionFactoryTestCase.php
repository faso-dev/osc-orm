<?php

namespace Tests;

use FSDV\Persistance\ConnectionFactory;
use PHPUnit\Framework\TestCase;

/**
 * ConnectionFactoryTestCase
 *
 * @author Anitche Chisom
 */
class ConnectionFactoryTestCase extends TestCase
{
    protected $connection;

    /**
    * Setup connection before each test.
    *
    * @return void
    */
    public function setUp(): void
    {
        parent::setUp();

        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/osc-orm/');
        $dotenv->load();

        $this->connection = (new ConnectionFactory);
    }

    /**
     * @test
     */
    public function initialize()
    {
        $this->assertInstanceOf(ConnectionFactory::class, $this->connection);
    }

    /**
     * @test
     */
    public function returnsPDOInstance()
    {
        $this->assertInstanceOf(\PDO::class, $this->connection->create([
                'driver'    => getenv('DB_CONNECTION'),
                'database'  => getenv('DB_DATABASE'),
                'host'      => getenv('DB_HOST'),
                'username'  => getenv('DB_USERNAME'),
                'password'  => getenv('DB_PASSWORD')
            ]));
    }
}
