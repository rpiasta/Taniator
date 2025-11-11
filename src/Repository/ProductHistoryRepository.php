<?php

namespace App\Repository;

use App\Container;
use App\Entity\ProductHistory;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class ProductHistoryRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repository;

    public function __construct()
    {
        $this->em = Container::getEntityManager();
        $this->repository = $this->em->getRepository(ProductHistory::class);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(ProductHistory $history): void
    {
        $this->em->persist($history);
        $this->em->flush();
    }

    public function findLatestByUser(User $user, int $limit = 10): array
    {
        return $this->repository->createQueryBuilder('ph')
            ->where('ph.user = :user')
            ->setParameter('user', $user)
            ->orderBy('ph.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
