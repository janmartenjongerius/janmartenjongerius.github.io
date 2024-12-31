<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

final class SkillFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (glob(__DIR__ . '/../../data/skill/*.json') as $file) {
            $data = json_decode(
                json: file_get_contents($file),
                flags: JSON_THROW_ON_ERROR
            );

            $skill = new Skill();
            $skill->setId(pathinfo($file, PATHINFO_FILENAME));
            $skill->setName($data->name);
            $skill->setDescription($data->description);

            $manager->persist($skill);
        }

        $manager->flush();
    }
}
