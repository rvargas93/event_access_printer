<?php

namespace App\Validator;

use ReflectionClass;

abstract class AbstractValidator
{
    protected abstract function getDtoClass(): string;

    protected abstract function validateItem(string $name, $value): bool;

    protected abstract function getAttributesRequired(): array;

    public function validate(array $payload): void
    {
        $reflectionClass = new ReflectionClass($this->getDtoClass());

        foreach ($this->getAttributesRequired() as $required) {
            if (!in_array($required, array_keys($payload))) {
                throw new ValidationException("$required is required");
            }
        }

        foreach ($payload as $item => $value) {
            foreach ($reflectionClass->getProperties() as $attribute) {
                if ($attribute->getName() === $item) {
                    if (!$this->validateItem($item, $value)) {
                        throw new ValidationException("$item is invalid");
                    }
                }
            }
        }
    }

    public function mapToDto(array $payload)
    {
        $reflectionClass = new ReflectionClass($this->getDtoClass());
        $dtoClass = $this->getDtoClass();
        $dto = new $dtoClass();

        foreach ($payload as $item => $value) {
            foreach ($reflectionClass->getProperties() as $attribute) {
                if ($attribute->getName() === $item) {
                    $setter = 'set' . ucfirst($attribute->getName());
                    $dto->$setter($value);
                }
            }
        }

        return $dto;
    }

}