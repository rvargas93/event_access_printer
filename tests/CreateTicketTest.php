<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateTicketTest extends WebTestCase
{

    public function testCreateTicket(): void
    {
        static::createClient()->request('POST', '/ticket', [
            'email' => 'rvargas@email.com',
            'name' => 'Rafael',
            'lastName' => 'Vargas',
            'birthday' => '2022-02-21',
            'country' => 'Spain',
            'city' => 'Madrid',
            'province' => 'Madrid',
            'street' => 'Calle Mayor, 10',
            'zip' => '28013',
            'type' => '1'
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Your ticket has been sent');
    }
}
