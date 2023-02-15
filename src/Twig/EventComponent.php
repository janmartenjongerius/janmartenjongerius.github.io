<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Event;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('event')]
final class EventComponent
{
    private Event $event;
    private bool $withSeparator;

    public function mount(Event $event, bool $withSeparator = false): void
    {
        $this->event = $event;
        $this->withSeparator = $withSeparator;
    }

    /** @noinspection PhpUnused */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /** @noinspection PhpUnused */
    public function isWithSeparator(): bool
    {
        return $this->withSeparator;
    }
}
