<?php

namespace CartbotPrivateUnit\Domain\User;

use PHPUnit\Framework\TestCase;
use CartbotPrivate\Domain\User\PasswordNotValidException;
use CartbotPrivate\Domain\User\PasswordPlainText;

class PasswordPlainTextTest extends TestCase
{
    /**
     * @dataProvider passwordsNotValid
     */
    public function testShouldThrownExceptionIfPasswordIsNotValid(string $password)
    {
        $this->expectException(PasswordNotValidException::class);
        new PasswordPlainText($password);
    }

    /**
     * @dataProvider passwordsValid
     */
    public function testShouldGiveMePasswordPlainTextClassIfPasswordIsValid(string $password)
    {
        $pass = new PasswordPlainText($password);
        $this->assertInstanceOf(PasswordPlainText::class, $pass);
    }

    public function passwordsNotValid()
    {
        return [
            [''],
            ['a'],
            ['a2'],
            ['a2a'],
            ['a1a2'],
            ['a1a24'],
            ['aaasss'],
            ['123456789'],
            ['asdfghjkl1234567890qwertyuiop12'],
        ];
    }

    public function passwordsValid()
    {
        return [
            ['aaa122'],
            ['A34567'],
            ['12a3Ardge5343'],
            ['1kdlAjjLfEe']
        ];
    }
}
