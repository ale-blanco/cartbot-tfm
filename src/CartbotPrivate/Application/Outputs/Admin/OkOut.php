<?php

namespace CartbotPrivate\Application\Outputs\Admin;

class OkOut implements \JsonSerializable
{
    public function jsonSerialize(): array
    {
        return ['ok' => 'ok'];
    }
}
