<?php

namespace Cartbot\Domain\User;

use Cartbot\Domain\Chat\ChatType;

class UserChat
{
    private $id;
    private $type;
    private $user;

    public function __construct(string $id, ChatType $type, User $user)
    {
        $this->id = $id;
        $this->type = $type->name();
        $this->user = $user;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function type(): ChatType
    {
        return new ChatType($this->type);
    }

    public function user(): User
    {
        return $this->user;
    }
}
