<?php

declare(strict_types=1);

namespace App\Model\Product\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_filters")
 */
class ProductFilters
{
    /**
     * @ORM\Column(type="product_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @ORM\Column(type="json", nullable=true, options={"jsonb"=true})
     */
    private $attributes;

    public function __construct(Id $id, array $attributes)
    {
        $this->id = $id;
        $this->attributes = $attributes;
    }
}