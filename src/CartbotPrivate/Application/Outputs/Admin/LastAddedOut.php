<?php

namespace CartbotPrivate\Application\Outputs\Admin;

class LastAddedOut implements \JsonSerializable
{
    private $added;

    public function __construct(array $added)
    {
        $this->added = $added;
    }

    public function jsonSerialize(): array
    {
        return [
            'added' => $this->added
        ];
    }
}
