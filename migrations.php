<?php

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use App\Container;
use Symfony\Component\Console\Application;
use Doctrine\Migrations\Tools\Console\Command;

require_once __DIR__ . '/vendor/autoload.php';

$entityManager = Container::getEntityManager();

$dependencyFactory = DependencyFactory::fromEntityManager(
    new ConfigurationArray([
        'migrations_paths' => [
            'App\Migrations' => __DIR__ . '/migrations'
        ],
        'all_or_nothing' => true,
        'check_database_platform' => true,
    ]),
    new ExistingEntityManager($entityManager)
);

$application = new Application('Doctrine Migrations');

$application->addCommands([
    new Command\DiffCommand($dependencyFactory),
    new Command\ExecuteCommand($dependencyFactory),
    new Command\GenerateCommand($dependencyFactory),
    new Command\MigrateCommand($dependencyFactory),
    new Command\StatusCommand($dependencyFactory),
    new Command\VersionCommand($dependencyFactory),
]);

$application->run();
