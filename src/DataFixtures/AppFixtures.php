<?php

namespace App\DataFixtures;

use App\Model\Brand\Entity\Brand;
use App\Model\Brand\Service\IBrandRepository;
use App\Model\Product\Entity\Id;
use App\Model\Brand\Entity\Id As BrandId;
use App\Model\Product\Entity\Product;
use App\Model\Product\Entity\ProductFilters;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $faker;
    private $brandRepository;

    public function __construct(IBrandRepository $brandRepository)
    {
        $this->faker = Factory::create();
        $this->brandRepository = $brandRepository;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 20; $i++) {

            $productFilters = new ProductFilters(Id::next(), [
                'color' => $this->faker->colorName,
                'size' => $this->faker->randomNumber(),
                'weight' => $this->faker->randomNumber()
            ]);

            $manager->persist($productFilters);

            $product = Product::create(
                Id::next(),
                new \DateTimeImmutable(),
                $this->faker->text(100),
                $this->faker->text(300),
                $productFilters,
                $this->faker->randomNumber(),
                $this->faker->randomNumber(),
            );

            $manager->persist($product);
        }
        $manager->flush();
    }
}
