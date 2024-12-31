<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class ImageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (glob(__DIR__ . '/../../data/image/*.jpeg') as $file) {
            $path = realpath($file);
            $manager->persist(Image::fromFile($path));
        }

        $manager->flush();
    }
}