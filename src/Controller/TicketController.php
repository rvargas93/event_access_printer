<?php

namespace App\Controller;

use App\Repository\TicketTypeRepository;
use App\Service\Email\EmailService;
use App\Service\TicketService;
use App\Validator\CreateTicketValidator;
use App\Validator\ValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TicketController extends AbstractController
{

    public function __construct(
        private TicketTypeRepository $ticketTypeRepository,
        private CreateTicketValidator $validator,
        private TicketService $ticketService,
        private EmailService $emailService,
    ) {}

    public function index(): Response
    {
        return $this->render('ticket/index.html.twig', [
            'types' => $this->ticketTypeRepository->findAll(),
        ]);
    }

    public function createTicket(Request $request): Response
    {
        $payload = $request->request->all();

        try {
            $this->validator->validate($payload);

        } catch(ValidationException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }

        $dto = $this->validator->mapToDto($payload);
        $ticket = $this->ticketService->createTicket($dto);

        $this->emailService->SendTicketEmail($ticket);

        return $this->render('ticket/ticket_created.html.twig', [
            'email' => $ticket->getCustomer()->getEmail(),
        ]);
    }
}
