<?php

namespace App\Service;

use App\Entity\Ticket;
use App\Entity\Customer;
use App\Dto\CreateTicketDto;
use App\Entity\Address;
use App\Repository\TicketTypeRepository;
use Doctrine\ORM\EntityManagerInterface;

class TicketService
{
    public function __construct(
        private TicketTypeRepository $ticketTypeRepository,
        private EntityManagerInterface $manager
    ) {}

    public function createTicket(CreateTicketDto $dto): Ticket
    {
        $address = new Address();
        $address
            ->setCity($dto->getCity())
            ->setCountry($dto->getCountry())
            ->setProvince($dto->getProvince())
            ->setStreet($dto->getStreet())
            ->setZip($dto->getZip());

        $customer = new Customer();
        $customer
            ->setName($dto->getName())
            ->setLastName($dto->getLastName())
            ->setEmail($dto->getEmail())
            ->setBirthday(\DateTime::createFromFormat(Customer::BIRTHDAY_FORMAT, $dto->getBirthday()))
            ->setAddress($address)
        ;

        $ticket = new Ticket();
        $ticket
            ->setCustomer($customer)
            ->setType($this->ticketTypeRepository->find($dto->getType()))
        ;

        $this->manager->persist($ticket);
        $this->manager->flush();

        return $ticket;
    }
}