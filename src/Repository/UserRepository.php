<?php

namespace App\Repository;

use App\Container;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class UserRepository
{
    private EntityManagerInterface $em;

    private EntityRepository $repository;

    public function __construct()
    {
        $this->em = Container::getEntityManager();
        $this->repository = $this->em->getRepository(User::class);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(User $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }

    public function findByEmail(string $email): ?User
    {
        return $this->repository->findOneBy(['email' => $email]);
    }
}
