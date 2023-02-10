<?php

namespace App\Entity;

use App\Repository\EmploymentSkillRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmploymentSkillRepository::class)]
class EmploymentSkill implements SkillInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'employmentSkills')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employment $employment = null;

    #[ORM\ManyToOne(inversedBy: 'employmentSkills')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Skill $skill = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployment(): ?Employment
    {
        return $this->employment;
    }

    public function setEmployment(?Employment $employment): self
    {
        $this->employment = $employment;

        return $this;
    }

    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    public function setSkill(?Skill $skill): self
    {
        $this->skill = $skill;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description ?? $this->skill?->getDescription();
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __toString(): string
    {
        return (string)$this->skill;
    }

    public function getName(): ?string
    {
        return $this->skill->getName();
    }
}
