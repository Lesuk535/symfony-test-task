<?php

declare(strict_types=1);

namespace App\Model\Product\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=App\Repository\ProductRepository::class)
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Column(type="product_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @ORM\Column(type="product_status")
     */
    private Status $status;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @ORM\Embedded(class="Price", columnPrefix = false)
     */
    private Price $price;

    /**
     * @ORM\Column(type="integer");
     */
    private $quantity = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Product\Entity\Img", mappedBy="product")
     */
    private Collection $images;

    /**
     * @ORM\ManyToMany(targetEntity="App\Model\Catalog\Entity\Catalog")
     * @ORM\JoinTable(name="products_categories",
     *     joinColumns={@JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="category_id", referencedColumnName="id")}
     *     )
     */
    private Collection $categories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Model\Product\Entity\ProductFilters")
     * @ORM\JoinTable(name="products_filters",
     *     joinColumns={@JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="filter_id", referencedColumnName="id")}
     *     )
     */
    private Collection $filters;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Brand\Entity\Brand")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id", nullable=true)
     */
    private $brand;

    public function __construct(Id $id, \DateTimeImmutable $date, string $name)
    {
        $this->id = $id;
        $this->createdAt = $date;
        $this->name = $name;
        $this->status = Status::inactive();
        $this->images = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->filters = new ArrayCollection();
    }

    public static function create(
        Id $id,
        \DateTimeImmutable $date,
        string $name,
        string $description,
        $attributes,
        int $quantity,
        int $price,
        ?int $discount=null
    ): self {
        $product = new self($id, $date, $name);
        $product->description = $description;
        $product->filters->add($attributes);
        $product->quantity = $quantity;
        $product->price = new Price($price, $discount);
        return $product;
    }
}
