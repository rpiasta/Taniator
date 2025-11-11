<?php

namespace App\Repository;

use App\Container;
use App\Entity\Product;
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

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function deleteByBarcode(string $barcode): bool
    {
        $product = $this->findByBarcode($barcode);
        if (!$product) {
            return false;
        }

        $this->em->remove($product);
        $this->em->flush();

        return true;
    }
}
