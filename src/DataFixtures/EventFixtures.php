<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Event;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

final class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (glob(__DIR__ . '/../../data/event/*.json') as $file) {
            $data = json_decode(
                json: file_get_contents($file),
                flags: JSON_THROW_ON_ERROR
            );

            $event = new Event();
            $event->setId((int)basename($file));
            $event->setName($data->name);
            $event->setDescription($data->description);
            $event->setLocation($data->location ?? '');
            $event->setUrl($data->url ?? '');
            $event->setStartAt(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::RFC3339,
                    $data->start_at
                )
            );
            $event->setEndAt(
                DateTimeImmutable::createFromFormat(
                    DateTimeInterface::RFC3339,
                    $data->end_at
                )
            );

            $manager->persist($event);
        }

        $manager->flush();
    }
}
