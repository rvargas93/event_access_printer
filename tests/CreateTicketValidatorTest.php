<?php

namespace App\Tests;

use App\Validator\CreateTicketValidator;
use App\Validator\ValidationException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CreateTicketValidatorTest extends KernelTestCase
{
    const PAYLOAD_TEMPLATE = [
        'email' => 'rvargas@email.com',
        'name' => 'Rafael',
        'lastName' => 'Vargas',
        'birthday' => '2022-02-21',
        'country' => 'Spain',
        'city' => 'Madrid',
        'province' => 'Madrid',
        'street' => 'Calle Mayor, 10',
        'zip' => '28013',
        'type' => '3'
    ];

    public function testValidateFail(): void
    {
        $kernel = self::bootKernel();

        $container = $kernel->getContainer();

        /** @var CreateTicketValidator $validator */
        $validator = $container->get(CreateTicketValidator::class);

        $payload = [];
        try {
            $validator->validate($payload);

        } catch(ValidationException $exception) {
            $this->assertEquals($exception->getMessage(), 'email is required');
        }

        $payload = self::PAYLOAD_TEMPLATE;
        $payload['email'] = 'fail';
        try {
            $validator->validate($payload);

        } catch(ValidationException $exception) {
            $this->assertEquals($exception->getMessage(), 'email is invalid');
        }

        $payload = self::PAYLOAD_TEMPLATE;
        $payload['birthday'] = '20222-01-21-2021';
        try {
            $validator->validate($payload);

        } catch(ValidationException $exception) {
            $this->assertEquals($exception->getMessage(), 'birthday is invalid');
        }

        $payload = self::PAYLOAD_TEMPLATE;
        $payload['zip'] = '2908';
        try {
            $validator->validate($payload);

        } catch(ValidationException $exception) {
            $this->assertEquals($exception->getMessage(), 'zip is invalid');
        }

        
        $payload = self::PAYLOAD_TEMPLATE;
        $payload['type'] = '4';
        try {
            $validator->validate($payload);

        } catch(ValidationException $exception) {
            $this->assertEquals($exception->getMessage(), 'type is invalid');
        }
    }

    public function testValidateSuccess(): void
    {
        $kernel = self::bootKernel();

        $container = $kernel->getContainer();

        /** @var CreateTicketValidator $validator */
        $validator = $container->get(CreateTicketValidator::class);

        $validator->validate(self::PAYLOAD_TEMPLATE);
        //if doesn´t throw an execption the validation is success.
        $this->assertTrue(true);
    }

    public function testMappingDto(): void
    {
        $kernel = self::bootKernel();

        $container = $kernel->getContainer();

        /** @var CreateTicketValidator $validator */
        $validator = $container->get(CreateTicketValidator::class);

        $dto = $validator->mapToDto(self::PAYLOAD_TEMPLATE);

        $this->assertEquals($dto->getEmail(), self::PAYLOAD_TEMPLATE['email']);
        $this->assertEquals($dto->getName(), self::PAYLOAD_TEMPLATE['name']);
        $this->assertEquals($dto->getLastName(), self::PAYLOAD_TEMPLATE['lastName']);
        $this->assertEquals($dto->getBirthday(), self::PAYLOAD_TEMPLATE['birthday']);
        $this->assertEquals($dto->getCountry(), self::PAYLOAD_TEMPLATE['country']);
        $this->assertEquals($dto->getCity(), self::PAYLOAD_TEMPLATE['city']);
        $this->assertEquals($dto->getProvince(), self::PAYLOAD_TEMPLATE['province']);
        $this->assertEquals($dto->getStreet(), self::PAYLOAD_TEMPLATE['street']);
        $this->assertEquals($dto->getZip(), self::PAYLOAD_TEMPLATE['zip']);
    }
}
