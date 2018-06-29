<?php

namespace CartbotPrivate\Application\Outputs\Admin;

class LastsEventsOut implements \JsonSerializable
{
    private $byType;
    private $byHour;
    private $labels;

    public function __construct(array $byType, array $byHour, array $labels)
    {
        $this->byType = $byType;
        $this->byHour = $byHour;
        $this->labels = $labels;
    }

    public function jsonSerialize(): array
    {
        return [
            'byType' => $this->byType,
            'byHour' => $this->byHour,
            'labels' => $this->labels
        ];
    }
}
