<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Catalog\Entity\Catalog;
use App\Model\Catalog\Entity\Id;
use App\Model\Category\Service\ICatalogRepository;
use App\Model\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CatalogRepository extends ServiceEntityRepository implements ICatalogRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Catalog::class);
    }

    public function getByIds(array $ids): array
    {
        $qb = $this->createQueryBuilder('c');
        return $qb->select('c')
            ->andWhere($qb->expr()->in('c.id', ':id'))
            ->setParameter(':id', $ids)
            ->getQuery()->getResult();
    }

    public function getById(Id $id): Catalog
    {
        /** @var Catalog $catalog */
        if (!$catalog = $this->findOneBy(['id' => $id->getValue()])) {
            throw new EntityNotFoundException('Category is not found');
        };
        return $catalog;
    }

    public function getMaxOrder(): int
    {
        $qb = $this->createQueryBuilder('c');
        $result =  $qb->select($qb->expr()->max('c.categoryOrder'))
            ->getQuery()->getSingleScalarResult();

        return (int) $result;
    }
}