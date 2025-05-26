<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Testimonial;
use stdClass;
use App\Entity\Image;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

final class TestimonialFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach (glob(__DIR__ . '/../../data/testimonial/*.json') as $file) {
            self::createTestimonial(
                manager: $manager,
                data: json_decode(
                    json: file_get_contents($file), 
                    flags: JSON_THROW_ON_ERROR
                )
            );
        }

        $manager->flush();
    }

    private static function createTestimonial(
        ObjectManager $manager, 
        stdClass $data
    ): void {
        $testimonial = new Testimonial();
        $testimonial->setName($data->name);
        $testimonial->setUrl($data->url);
        $testimonial->setRelation($data->relation);
        $testimonial->setDate(
            new DateTimeImmutable(
                sprintf('%s 00:00:00.00', $data->date)
            )
        );
        $testimonial->setContent($data->content);
        $testimonial->setAvatar(
            $manager->find(Image::class, $data->avatar ?? '')
        );

        $manager->persist($testimonial);
    }

    /**
     * @phpstan-return array<class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [ImageFixtures::class];
    }
}
