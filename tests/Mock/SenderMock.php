<?php

namespace App\Tests\Mock;

use App\Service\Email\SenderDto;
use App\Service\Email\SenderResponse;
use App\Service\Email\SenderInterface;

class SenderMock implements SenderInterface
{
    public function send(SenderDto $dto): SenderResponse
    {
        $response = new SenderResponse();
        $response
            ->setSend(true)
            ->setCode(200)
            ->setMessage('')
        ;

        return $response;
    }

}