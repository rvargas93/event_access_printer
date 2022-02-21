<?php

namespace App\Service\Email;

interface SenderInterface
{
    public function send(SenderDto $dto): SenderResponse;
}