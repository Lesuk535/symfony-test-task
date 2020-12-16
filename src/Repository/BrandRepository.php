<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Brand\Entity\Brand;
use App\Model\Brand\Service\IBrandRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class BrandRepository extends ServiceEntityRepository implements IBrandRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brand::class);
    }
}