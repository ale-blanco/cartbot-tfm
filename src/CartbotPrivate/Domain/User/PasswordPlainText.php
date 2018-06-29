<?php

namespace CartbotPrivate\Domain\User;

class PasswordPlainText
{
    private $password;

    public function __construct(string $password)
    {
        if (!$this->validate($password)) {
            throw new PasswordNotValidException();
        }
        $this->password = $password;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function equal(PasswordPlainText $password): bool
    {
        return $this->password() === $password->password();
    }

    private function validate(string $password): bool
    {
        $len = mb_strlen($password, 'UTF-8');
        if ($len < 6 || $len > 30) {
            return false;
        }

        if (!preg_match('/([a-zA-Z]+[0-9]+|[0-9]+[a-zA-Z])/', $password)) {
            return false;
        }

        return true;
    }
}
