<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill implements SkillInterface
{
    #[ORM\Id]
    #[ORM\Column]
    private ?string $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'skill', targetEntity: EmploymentSkill::class, orphanRemoval: true)]
    private Collection $employmentSkills;

    public function __construct()
    {
        $this->employmentSkills = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, EmploymentSkill>
     */
    public function getEmploymentSkills(): Collection
    {
        return $this->employmentSkills;
    }

    public function addEmploymentSkill(EmploymentSkill $employmentSkill): self
    {
        if (!$this->employmentSkills->contains($employmentSkill)) {
            $this->employmentSkills->add($employmentSkill);
            $employmentSkill->setSkill($this);
        }

        return $this;
    }

    public function removeEmploymentSkill(EmploymentSkill $employmentSkill): self
    {
        if ($this->employmentSkills->removeElement($employmentSkill)) {
            // set the owning side to null (unless already changed)
            if ($employmentSkill->getSkill() === $this) {
                $employmentSkill->setSkill(null);
            }
        }

        return $this;
    }
}
