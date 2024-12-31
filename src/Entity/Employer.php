<?php

namespace App\Entity;

use App\Repository\EmployerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployerRepository::class)]
class Employer
{
    #[ORM\Id]
    #[ORM\Column]
    private ?string $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'employer', targetEntity: Employment::class, orphanRemoval: true)]
    private Collection $employments;

    #[ORM\ManyToOne]
    private ?Image $logo = null;

    public function __construct()
    {
        $this->employments = new ArrayCollection();
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
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

    /**
     * @return Collection<int, Employment>
     */
    public function getEmployments(): Collection
    {
        return $this->employments;
    }

    public function addEmployment(Employment $employment): self
    {
        if (!$this->employments->contains($employment)) {
            $this->employments->add($employment);
            $employment->setEmployer($this);
        }

        return $this;
    }

    public function removeEmployment(Employment $employment): self
    {
        if ($this->employments->removeElement($employment)) {
            // set the owning side to null (unless already changed)
            if ($employment->getEmployer() === $this) {
                $employment->setEmployer(null);
            }
        }

        return $this;
    }

    public function getLogo(): ?Image
    {
        return $this->logo;
    }

    public function setLogo(?Image $logo): self
    {
        $this->logo = $logo;

        return $this;
    }
}
