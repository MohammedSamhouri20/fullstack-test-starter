<?php

namespace App\Scandiweb\Config;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;
use Dotenv\Dotenv;

class Database
{
    public static function getEntityManager(): EntityManager
    {
        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        // Configure Doctrine ORM
        $config = ORMSetup::createAttributeMetadataConfiguration(
            [__DIR__ . '/../Models'],
            true
        );

        // Define database connection parameters
        $connection = DriverManager::getConnection([
            'dbname'   => $_ENV['DB_NAME'],
            'user'     => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS'] ?: null,  // Handle empty password
            'host'     => $_ENV['DB_HOST'],
            'driver'   => 'pdo_mysql',
        ], $config);

        return new EntityManager($connection, $config);
    }
}
