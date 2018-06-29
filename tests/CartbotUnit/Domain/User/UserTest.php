<?php

namespace CartbotUnit\Domain\User;

use PHPUnit\Framework\TestCase;
use Cartbot\Domain\Client\Client;
use Cartbot\Domain\User\CustomerToken;
use Cartbot\Domain\User\User;

class UserTest extends TestCase
{
    public function testShouldGiveMeOriginalData()
    {
        $id = '44';
        $name = 'username';
        $token = new CustomerToken('lskajflksdjkfj', new \DateTimeImmutable());
        $client = new Client('98', 'theclient', '', '');
        $user = new User($id, $name, $token, $client);
        $this->assertEquals($id, $user->id());
        $this->assertEquals($name, $user->name());
        $this->assertEquals($token, $user->customerToken());
        $this->assertEquals($client, $user->client());
    }
}
