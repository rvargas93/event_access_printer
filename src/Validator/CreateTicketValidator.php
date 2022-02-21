<?php

namespace App\Validator;

use App\Dto\CreateTicketDto;
use App\Entity\Customer;
use App\Repository\TicketTypeRepository;

class CreateTicketValidator extends AbstractValidator
{
    public function __construct(
        private TicketTypeRepository $ticketTypeRepository
    ) {}

    protected function getDtoClass(): string
    {
        return CreateTicketDto::class;
    }

    protected function validateItem(string $name, $value): bool
    {
        switch($name) {
            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL);

            case 'birthday':
                return \DateTime::createFromFormat(Customer::BIRTHDAY_FORMAT, $value) !== false;

            case 'zip':
                return preg_match('/^\d{5}$/', $value);

            case 'type':
                return $this->ticketTypeRepository->find($value) !== null;

            default:
                return true;
        }
    }

    protected function getAttributesRequired(): array
    {
        return ['email', 'name', 'lastName', 'birthday', 'country', 'city', 'province', 'street', 'zip'];
    }

}