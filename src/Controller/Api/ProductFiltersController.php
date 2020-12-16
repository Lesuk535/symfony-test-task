<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\ReadModel\Product\ProductFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductFiltersController extends AbstractController
{
    private $productFetcher;

    public function __construct(ProductFetcher $productFetcher)
    {
        $this->productFetcher = $productFetcher;
    }

    /**
     * @Route("/api/filters/list/{id}", name="filters.list")
     */
    public function showFilters($id)
    {
        $filters = $this->productFetcher->getProductFilterById($id);
        $attributes = [];

        foreach ($filters as $filter) {
            $attributes['attributes'][] = json_decode($filter->attributes, true);
        }
        return $this->json($attributes);
    }
}