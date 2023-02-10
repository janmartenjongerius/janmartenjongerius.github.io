<?php

namespace App\Entity;

use App\Repository\EmploymentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmploymentRepository::class)]
class Employment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'employments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employer $employer = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'employment', targetEntity: EmploymentSkill::class, orphanRemoval: true)]
    private Collection $employmentSkills;

    public function __construct()
    {
        $this->employmentSkills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getEmployer(): ?Employer
    {
        return $this->employer;
    }

    public function setEmployer(?Employer $employer): self
    {
        $this->employer = $employer;

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): self
    {
        $this->endAt = $endAt;

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
            $employmentSkill->setEmployment($this);
        }

        return $this;
    }

    public function removeEmploymentSkill(EmploymentSkill $employmentSkill): self
    {
        if ($this->employmentSkills->removeElement($employmentSkill)) {
            // set the owning side to null (unless already changed)
            if ($employmentSkill->getEmployment() === $this) {
                $employmentSkill->setEmployment(null);
            }
        }

        return $this;
    }
}
