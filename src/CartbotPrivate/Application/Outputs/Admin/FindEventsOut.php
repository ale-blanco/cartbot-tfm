<?php

namespace CartbotPrivate\Application\Outputs\Admin;

class FindEventsOut implements \JsonSerializable
{
    private $listEvents;
    private $total;

    public function __construct(array $listEvents, int $total)
    {
        $this->listEvents = $listEvents;
        $this->total = $total;
    }

    public function jsonSerialize(): array
    {
        return [
            'listEvents' => $this->listEvents,
            'total' => $this->total
        ];
    }
}
