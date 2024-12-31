<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\Column]
    private ?string $id = null;

    #[ORM\Column(type: Types::BLOB)]
    private $content = null;

    public static function fromFile(string $path): static
    {
        $image = new static();
        $image->id = pathinfo($path, PATHINFO_BASENAME);
        $image->content = file_get_contents($path);
        return $image;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return null|resource
     */
    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }
}
