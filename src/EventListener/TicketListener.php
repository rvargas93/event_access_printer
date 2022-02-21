<?php

namespace App\EventListener;

use App\Entity\Ticket;

class TicketListener
{
    public function prePersist(Ticket $ticket): void
    {
        $ticket->setCreateAt(new \DateTime());
    }
}