<?php

declare(strict_types=1);

namespace App\ReadModel\Product;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;

class ProductFetcher
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getProductFilterById($id)
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'attributes',
                'product_id',
                'filter_id'
            )
            ->from('product_filters', 'product_filters')
            ->innerJoin('product_filters', 'products_filters', 'products_filters', 'product_filters.id = products_filters.filter_id')
            ->where('product_id = :id')
            ->setParameter(':id', $id)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, ProductFilterView::class);

        return $stmt->fetchAll();
    }
}