<?php

namespace App\Service\Email;

class SenderDto
{
    private array $tos;
    private string $subject;
    private array $data;

    public function getTos(): array
    {
        return $this->tos;
    }

    public function setTos(array $tos): self
    {
        $this->tos = $tos;

        return $this;
    }

    public function addTo(string $to): self
    {
        $this->tos[] = $to;

        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

}