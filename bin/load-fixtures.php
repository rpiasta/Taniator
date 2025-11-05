#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Container;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

$entityManager = Container::getEntityManager();

$loader = new Loader();
$loader->loadFromDirectory(__DIR__ . '/../src/DataFixtures');

$purger = new ORMPurger();
$executor = new ORMExecutor($entityManager, $purger);
$executor->purge();
$executor->execute($loader->getFixtures());

echo "Fixtures loaded successfully.\n";
