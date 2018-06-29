<?php

namespace CartbotPrivateUnit\Domain\User;

use PHPUnit\Framework\TestCase;
use Cartbot\Domain\Client\Client;
use CartbotPrivate\Domain\User\Email;
use CartbotPrivate\Domain\User\UserClient;
use CartbotPrivate\Domain\User\UserNameNotValidException;

class UserClientTest extends TestCase
{
    /**
     * @dataProvider usernameNotValid
     */
    public function testShouldThrownExceptionIfUsernameIsNotValid(string $userName)
    {
        $this->expectException(UserNameNotValidException::class);
        new UserClient(new Client('1', 'client', '', ''), $userName, new Email('valido@valido.com'), true);
    }

    public function testShouldGiveMeOriginalData()
    {
        $client = new Client('456', 'theclient', '', '');
        $userName = 'theusername';
        $email = new Email('name@theclient.com');
        $active = false;
        $userClient = new UserClient($client, $userName, $email, $active);
        $this->assertEquals($client, $userClient->client());
        $this->assertEquals($userName, $userClient->username());
        $this->assertTrue($userClient->email()->equal($email));
        $this->assertEquals($active, $userClient->isActive());
    }

    public function usernameNotValid()
    {
        return [
            [''],
            ['a'],
            ['as'],
            ['asd'],
            ['asdf']
        ];
    }
}
