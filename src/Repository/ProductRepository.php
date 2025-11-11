<?php

namespace App\Repository;

use App\Container;
use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class ProductRepository
{
    private EntityManagerInterface $em;

    private EntityRepository $repository;

    public function __construct()
    {
        $this->em = Container::getEntityManager();
        $this->repository = $this->em->getRepository(Product::class);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function save(Product $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }

    public function findByBarcode(string $barcode): ?Product
    {
        return $this->repository->findOneBy(['barcode' => $barcode]);
    }

    public function findLatestByBarcodeAndStore(string $barcode, string $store): ?Product
    {
        return $this->repository->createQueryBuilder('p')
            ->where('p.barcode = :barcode')
            ->andWhere('p.store = :store')
            ->setParameter('barcode', $barcode)
            ->setParameter('store', $store)
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return Product[]
     */
    public function findByBarcodeStoreAndDay(string $barcode, DateTimeImmutable $day): array
    {
        $dayStart = $day->setTime(0, 0, 0);
        $dayEnd   = $day->setTime(23, 59, 59);

        return $this->repository->createQueryBuilder('p')
            ->where('p.barcode = :barcode')
            ->andWhere('p.createdAt BETWEEN :start AND :end')
            ->setParameter('barcode', $barcode)
            ->setParameter('start', $dayStart)
            ->setParameter('end', $dayEnd)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
