<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;

require_once "vendor/autoload.php";

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/src/Models'],
    isDevMode: true,
);

$connection = DriverManager::getConnection([
    'dbname'   => $_ENV['DB_NAME'],
    'user'     => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'host'     => $_ENV['DB_HOST'],
    'driver'   => 'pdo_mysql',
], $config);

$entityManager = new EntityManager($connection, $config);

return $entityManager;
