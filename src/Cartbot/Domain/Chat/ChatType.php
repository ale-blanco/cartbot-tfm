<?php

namespace Cartbot\Domain\Chat;

class ChatType
{
    private const TELEGRAM = 'telegram';
    private const ASSISTANT = 'assistant';
    private $name;

    public function __construct(string $name)
    {
        if (!in_array($name, [self::TELEGRAM, self::ASSISTANT])) {
            throw new ChatTypeNotValidException();
        }
        $this->name = $name;
    }

    public static function createTelegam(): self
    {
        return new self(self::TELEGRAM);
    }

    public static function createAssistant(): self
    {
        return new self(self::ASSISTANT);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isEqual(ChatType $chatType): bool
    {
        return $this->name === $chatType->name();
    }

    public function __toString()
    {
        return $this->name;
    }
}
