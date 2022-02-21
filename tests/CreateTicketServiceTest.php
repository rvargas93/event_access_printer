<?php

namespace App\Tests;

use App\Dto\CreateTicketDto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\TicketService;

class CreateTicketServiceTest extends KernelTestCase
{
    public function testCreateTicketEntity(): void
    {
        $kernel = self::bootKernel();

        $container = $kernel->getContainer();

        /** @var TicketService $service */
        $service = $container->get(TicketService::class);

        $ticketDto = new CreateTicketDto();
        $ticketDto
            ->setName('test name')
            ->setLastName('test last name')
            ->setEmail('test@example.com')
            ->setBirthday('1987-08-08')
            ->setCountry('test county')
            ->setCity('test city')
            ->setProvince('test province')
            ->setStreet('test street')
            ->setZip('12345')
            ->setType('2')
        ;

        $ticket = $service->createTicket($ticketDto);

        $this->assertEquals($ticket->getCustomer()->getName(), $ticketDto->getName());
        $this->assertEquals($ticket->getCustomer()->getLastName(), $ticketDto->getLastName());
        $this->assertEquals($ticket->getCustomer()->getEmail(), $ticketDto->getEmail());
        $this->assertEquals($ticket->getCustomer()->getBirthday()->format('Y-d-m'), $ticketDto->getBirthday());
        $this->assertEquals($ticket->getCustomer()->getAddress()->getCountry(), $ticketDto->getCountry());
        $this->assertEquals($ticket->getCustomer()->getAddress()->getCity(), $ticketDto->getCity());
        $this->assertEquals($ticket->getCustomer()->getAddress()->getProvince(), $ticketDto->getProvince());
        $this->assertEquals($ticket->getCustomer()->getAddress()->getStreet(), $ticketDto->getStreet());
        $this->assertEquals($ticket->getCustomer()->getAddress()->getZip(), $ticketDto->getZip());
        $this->assertEquals($ticket->getType()->getId(), $ticketDto->getType());
    }
}
