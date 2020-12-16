<?php

declare(strict_types=1);

namespace App\Model\Brand\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=App\Repository\BrandRepository::class)
 * @ORM\Table(name="brand")
 */
class Brand
{
    /**
     * @ORM\Column(type="brand_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    public function __construct(Id $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}