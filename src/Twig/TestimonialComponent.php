<?php

namespace App\Twig;

use App\Entity\Testimonial;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('testimonial')]
class TestimonialComponent
{
    private Testimonial $testimonial;

    public function mount(Testimonial $testimonial): void
    {
        $this->testimonial = $testimonial;
    }

    /** @noinspection PhpUnused */
    public function getTestimonial(): Testimonial
    {
        return $this->testimonial;
    }
}