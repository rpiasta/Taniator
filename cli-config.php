<?php

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use App\Container;

require_once __DIR__ . '/vendor/autoload.php';

$entityManager = Container::getEntityManager();

return DependencyFactory::fromEntityManager(
    new ConfigurationArray([
        'migrations_paths' => [
            'App\Migrations' => __DIR__ . '/migrations'
        ],
        'all_or_nothing' => true,
        'check_database_platform' => true,
    ]),
    new ExistingEntityManager($entityManager)
);
