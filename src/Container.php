<?php

namespace App;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class Container
{
    private static ?EntityManager $entityManager = null;

    public static function getEntityManager(): EntityManager
    {
        if (self::$entityManager === null) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->safeLoad();

            $isDevMode = ($_ENV['APP_ENV'] ?? 'dev') === 'dev';

            $cache = $isDevMode
                ? new ArrayAdapter()
                : new FilesystemAdapter(directory: '/tmp/doctrine');

            $config = ORMSetup::createAttributeMetadataConfiguration(
                paths: [__DIR__ . '/Entity'],
                isDevMode: $isDevMode,
                cache: $cache
            );

            $dbUrl = $_ENV['DATABASE_URL'] ?? 'mysql://app_user:app_pass@db:3306/app_db';
            $parsed = parse_url($dbUrl);

            $connectionParams = [
                'driver'   => 'pdo_mysql',
                'host'     => $parsed['host'] ?? $_ENV['DB_HOST'],
                'port'     => $parsed['port'] ?? $_ENV['DB_PORT'],
                'user'     => $parsed['user'] ?? $_ENV['DB_USER'],
                'password' => $parsed['pass'] ?? $_ENV['DB_PASS'],
                'dbname'   => ltrim($parsed['path'] ?? '/app_db', '/'),
                'charset'  => 'utf8mb4',
            ];

            $conn = DriverManager::getConnection($connectionParams, $config);
            self::$entityManager = new EntityManager($conn, $config);
        }

        return self::$entityManager;
    }
}
