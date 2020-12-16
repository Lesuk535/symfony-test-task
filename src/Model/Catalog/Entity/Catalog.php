<?php

declare(strict_types=1);

namespace App\Model\Catalog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * @ORM\Entity(repositoryClass=App\Repository\CatalogRepository::class)
 * @ORM\Table(name="catalog")
 */
class Catalog
{
    /**
     * @ORM\Column(type="catalog_id")
     * @ORM\Id
     */
    private Id $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @OneToMany(targetEntity="Catalog", mappedBy="parent", cascade={"persist"}, fetch="EAGER"))
     */
    private $children;

    /**
     * @ManyToOne(targetEntity="Catalog", inversedBy="children")
     * @JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="catalog_status")
     */
    private Status $status;

    /**
     * @ORM\Column(type="integer", unique=true, nullable=true)
     */
    private ?int $catalogOrder;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $image;

    public function __construct(Id $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->children = new ArrayCollection();
    }

    public static function create(
        Id $id,
        string $name,
        int $order,
        ?string $imagePath,
        ?string $description,
        ?array $children
    ): self {
        $catalog = new self($id, $name);
        $catalog->catalogOrder = $order;
        $catalog->description = $description;
        $catalog->status = Status::inactive();
        $catalog->image = $imagePath;
        $catalog->attachChildren($children);
        return $catalog;
    }

    public function edit(
        string $name,
        ?string $description
    ) {
        $this->name = $name;
        $this->description = $description;
    }

    public function attachChildren(array $children)
    {
        foreach ($children as $child) {
            $this->attachChild($child);
        }
    }

    public function detachChildren(array $children)
    {
        foreach ($children as $child) {
            $this->detachChild($child);
        }
    }

    public function changeImage(string $image)
    {
        $this->image = $image;
    }

    public function changeParent(Catalog $parent)
    {
        if ($this->children->contains($parent)) {
            throw new \DomainException('You can\'t assign parent category which is subcategory.');
        }
        $this->parent = $parent;
    }

    public function changeOrder(?int $order)
    {
        $this->catalogOrder = $order;
    }

    public function changeStatus(Status $status)
    {
        if ($this->status->getStatus() === $status->getStatus()) {
            throw new \DomainException('This status has already been selected.');
        }
        $this->status = $status;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    private function attachChild(Catalog $child)
    {
        if ($this->id === $child->id) {
            throw new \DomainException('You cannot make a category a subcategory of itself.');
        };

        if ($this->children->contains($child)) {
            throw new \DomainException(sprintf('The category already has a %s subcategory.', $child->name));
        }

        if ($child->hasParent()) {
            throw new \DomainException(sprintf('The %s already has a parent category.', $child->name));
        }

        $child->changeParent($this);
        $this->children->add($child);
    }

    private function deleteParent()
    {
        $this->parent = null;
    }

    private function detachChild(Catalog $child)
    {
        $child->deleteParent();
        $this->children->removeElement($child);
    }

    private function hasParent(): bool
    {
        return !is_null($this->parent);
    }
}