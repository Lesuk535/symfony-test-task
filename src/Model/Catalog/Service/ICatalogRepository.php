<?php

declare(strict_types=1);

namespace App\Model\Category\Service;

use App\Model\Catalog\Entity\Catalog;
use App\Model\Catalog\Entity\Id;

interface ICatalogRepository
{
    public function getByIds(array $ids): array;
    public function getById(Id $id): Catalog;
    public function getMaxOrder(): int;
}