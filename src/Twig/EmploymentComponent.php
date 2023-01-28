<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Employment;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('employment')]
final class EmploymentComponent
{
    private Employment $employment;

    public function mount(Employment $employment): void
    {
        $this->employment = $employment;
    }

    /** @noinspection PhpUnused */
    public function getEmployment(): Employment
    {
        return $this->employment;
    }
}
