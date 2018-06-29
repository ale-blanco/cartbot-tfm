<?php

namespace CartbotPrivateUnit\Domain\User;

use PHPUnit\Framework\TestCase;
use CartbotPrivate\Domain\User\Email;
use CartbotPrivate\Domain\User\EmailNotValidException;

class EmailTest extends TestCase
{
    /**
     * @dataProvider emailsNotValids
     */
    public function testShouldThrownExceptionIFNotVAlidEmail(string $email)
    {
        $this->expectException(EmailNotValidException::class);
        new Email($email);
    }

    /**
     * @dataProvider emailsValid
     */
    public function testShouldCreateEmailClassIfEmailValid(string $email)
    {
        $emailClass = new Email($email);
        $this->assertInstanceOf(Email::class, $emailClass);
    }

    /**
     * @dataProvider emailsValid
     */
    public function testShouldGiveMeEmailOriginal(string $email)
    {
        $this->assertEquals($email, (new Email($email))->email());
    }

    /**
     * @dataProvider emailsValid
     */
    public function testShouldFalseIfIsDiferentEmail(string $email)
    {
        $emailClass = new Email($email);
        $this->assertFalse($emailClass->equal(new Email('aaaa@aaaa.com')));
    }

    /**
     * @dataProvider emailsValid
     */
    public function testShouldTrueIfIsEqualEmail(string $email)
    {
        $emailClass = new Email($email);
        $this->assertTrue($emailClass->equal(new Email($email)));
    }

    public function emailsNotValids()
    {
        return [
            [''],
            ['a@a'],
            ['sdlkfjdlkjdljfl'],
            ['lskdafjlkdsj@dsalkfj'],
            ['algo@@dominio.com']
        ];
    }

    public function emailsValid()
    {
        return [
            ['dddd@ddddd.com'],
            ['ddd444@eeee.es']
        ];
    }
}
