<?php

declare(strict_types=1);

namespace App\DataFixtures;

use stdClass;
use App\Entity\Image;
use App\Entity\Skill;
use RuntimeException;
use DateTimeImmutable;
use App\Entity\Employer;
use App\Entity\Employment;
use App\Entity\EmploymentSkill;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

final class EmployerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach (glob(__DIR__ . '/../../data/employer/*.json') as $file) {
            self::createEmployer(
                manager: $manager,
                id: pathinfo($file, PATHINFO_FILENAME),
                data: json_decode(
                    json: file_get_contents($file), 
                    flags: JSON_THROW_ON_ERROR
                )
            );
        }

        $manager->flush();
    }

    private static function createEmployer(
        ObjectManager $manager, 
        string $id, 
        stdClass $data
    ): void {
        $employer = new Employer();
        $employer->setId($id);
        $employer->setName($data->name);
        $employer->setDescription($data->description);
        $employer->setLogo(
            $manager->find(Image::class, $data->logo ?? '')
        );

        $manager->persist($employer);

        foreach ($data->positions as $position) {
            self::createPosition(
                manager: $manager,
                employer: $employer,
                position: $position
            );
        }
    }

    private static function createPosition(
        ObjectManager $manager,
        Employer $employer,
        stdClass $position
    ): void {
        $employment = new Employment();
        $employment->setEmployer($employer);
        $employment->setTitle($position->title);
        $employment->setDescription($position->description);
        $employment->setStartAt(
            DateTimeImmutable::createFromFormat('Y-m-d', $position->start_at)
        );

        if ($position->end_at) {
            $employment->setEndAt(
                DateTimeImmutable::createFromFormat('Y-m-d', $position->end_at)
            );
        }

        foreach ($position->skills as $skill) {
            self::createSkill(
                manager: $manager,
                employment: $employment,
                skill: $skill
            );
        }

        $manager->persist($employment);
    }

    private static function createSkill(
        ObjectManager $manager,
        Employment $employment,
        stdClass $skill
    ): void {
        $employmentSkill = new EmploymentSkill();
        $employmentSkill->setDescription($skill->description ?? null);
        $employmentSkill->setEmployment($employment);
        $employmentSkill->setSkill(
            $manager->find(Skill::class, $skill->id)
        );

        if ($employmentSkill->getSkill() === null) {
            throw new RuntimeException(
                sprintf('Missing skill <%s>', $skill->id)
            );
        }

        $manager->persist($employmentSkill);
        $employment->addEmploymentSkill($employmentSkill);
    }

    /**
     * @phpstan-return array<class-string<FixtureInterface>>
     */
    public function getDependencies(): array
    {
        return [
            ImageFixtures::class, 
            SkillFixtures::class
        ];
    }
}
