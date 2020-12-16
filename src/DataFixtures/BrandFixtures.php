<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Model\Brand\Entity\Brand;
use App\Model\Brand\Entity\Id;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BrandFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 20; $i++) {
            $brand = new Brand(Id::next(), $this->faker->text(20));
            $manager->persist($brand);
        }
        $manager->flush();
    }
}