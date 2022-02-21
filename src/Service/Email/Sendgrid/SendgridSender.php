<?php

namespace App\Service\Email\Sendgrid;

use App\Service\Email\SenderDto;
use App\Service\Email\SenderResponse;
use App\Service\Email\SenderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use SendGrid\Mail\Mail;
use Twig\Environment;

class SendgridSender implements SenderInterface
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
        private Environment $twig
    ) {}

    public function send(SenderDto $dto): SenderResponse
    {
        $sendgrid = new \SendGrid($this->parameterBag->get('sendgrid_api_key'));

        $html = $this->twig->render('email/new_ticket.html.twig', $dto->getData());

        $email = new Mail();
        $email->setFrom($this->parameterBag->get('email_from'));
        $email->setSubject($dto->getSubject());
        $email->addTo($dto->getTos()[0]);
        $email->addContent('text/html', $html);

        $sendgridResponse = $sendgrid->send($email);

        $response = new SenderResponse();
        $response->setCode($sendgridResponse->statusCode());
        $response->setMessage($sendgridResponse->body());
        $response->setSend($response->getCode() >= 200 && $response->getCode() <= 299);

        return $response;
    }

}