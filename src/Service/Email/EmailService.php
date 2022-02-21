<?php

namespace App\Service\Email;

use App\Entity\Ticket;

class EmailService
{
    public function __construct(
        private SenderInterface $sender
    ) {}

    public function SendTicketEmail(Ticket $ticket): bool
    {
        $senderDto = new SenderDto();
        $senderDto
            ->addTo($ticket->getCustomer()->getEmail())
            ->setSubject('subject')
            ->setData([
                'name' => $ticket->getCustomer()->getName(),
                'lastName' => $ticket->getCustomer()->getLastName(),
                'createdAt' => $ticket->getCreatedAt()
            ]);

        $response = $this->sender->send($senderDto);

        return $response->isSend();
    }
}