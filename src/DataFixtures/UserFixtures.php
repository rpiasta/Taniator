<?php

namespace App\DataFixtures;

use App\Constraints\UserRole;
use App\Constraints\UserStatus;
use App\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $admin = new User(
            email: 'admin@example.com',
            password: password_hash('admin123', PASSWORD_DEFAULT),
            name: 'Administrator',
            status: UserStatus::ACTIVE->value,
            role: UserRole::ADMIN->value
        );

        $manager->persist($admin);
        $manager->flush();
    }
}
